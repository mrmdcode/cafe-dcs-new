<?php
namespace App\Http\Controllers\Company;

use App\Enums\CompanySubscriptionStatus;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanySubscription;
use App\Services\ZarinpalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageSubscriptionController extends Controller
{
    protected ZarinpalService $zarinpal;

                                   // Subscription plan configuration – you can move these to config or database
    protected int $amount    = 0;  // in IRT (e.g. 50,000 toman = 500,000 IRR? adjust accordingly)
    protected int $validDays = 30; // subscription duration in days

    public function __construct(ZarinpalService $zarinpal)
    {
        $this->zarinpal = $zarinpal;
    }

    /**
     * Show the subscription payment page.
     */
    public function showPaymentPage()
    {
        $user    = Auth::user();
        $company = $user->company;

        if (! $company || ! $company->fee_received) {
            abort(403, 'شرکت شما تعرفه‌ای تعیین نکرده است.');
        }

        $this->amount = (int) $company->fee_received;
        $amount       = $this->amount;
        return view('dashboard.company.manager.subscription', compact('amount'));
    }

    /**
     * Send payment request to Zarinpal and redirect to bank gateway.
     */
    public function requestPayment(Request $request)
    {
        $user    = Auth::user();
        $company = $user->company;
        if (! $user || ! $company) {
            return redirect()->route('dashboard')->with('error', 'Company not found.');
        }

        $amount      = (int) $company->fee_received;
        $description = 'اشتراک ماهانه - ' . ($user->company->name ?? '');
        $callbackUrl = route('subscription.callback');

        // Optionally pass user's mobile/email
        $mobile = $user->mobile ?? null;
        $email  = $user->email ?? null;

        $result = $this->zarinpal->request($amount, $description, $callbackUrl, $mobile, $email);

        if ($result['success']) {
            // Store payment details temporarily – we can use session or database
            session()->put('pending_payment', [
                'authority'  => $result['authority'],
                'amount'     => $amount,
                'company_id' => $user->company_id,
            ]);

            return redirect()->away($result['payment_url']);
        }

        return back()->with('error', 'خطا در اتصال به درگاه پرداخت: ' . ($result['message'] ?? 'Unknown error'));
    }

    /**
     * Callback from Zarinpal after user attempts to pay.
     */
    public function callback(Request $request)
    {
        $authority = $request->query('Authority');
        $status    = $request->query('Status');

        $pending = session()->get('pending_payment');

        // Basic validation
        if (! $authority || ! $pending || $pending['authority'] !== $authority) {
            return redirect()->route('subscription.required')
                ->with('error', 'اطلاعات پرداخت نامعتبر است.');
        }

        if ($status !== 'OK') {
            return redirect()->route('subscription.required')
                ->with('error', 'پرداخت توسط کاربر لغو شد.');
        }

        // Verify the transaction with Zarinpal
        $verification = $this->zarinpal->verify($authority, $pending['amount']);

        if (! $verification['success']) {
            return redirect()->route('subscription.required')
                ->with('error', 'تأیید پرداخت ناموفق بود: ' . ($verification['message'] ?? 'خطا'));
        }

        // Payment successful – activate subscription for the company
        DB::transaction(function () use ($pending, $verification, $authority) {
            $companyId = $pending['company_id'];

            $company = Company::find($companyId);
            $company->active();

            // Optional: deactivate any existing active subscriptions for this company
            CompanySubscription::where('company_id', $companyId)
                ->where('status', CompanySubscriptionStatus::ACTIVE)
                ->update(['status' => CompanySubscriptionStatus::EXPIRED]); // or 'canceled'

            // Create new active subscription
            CompanySubscription::create([
                'company_id'  => $companyId,
                'status'      => CompanySubscriptionStatus::ACTIVE,
                'starts_at'   => now(),
                'ends_at'     => now()->addDays($this->validDays),
                'payment_ref' => $verification['ref_id'] ?? null,
                'authority'   => $authority,
            ]);
        });

        // Clear the pending session data
        session()->forget('pending_payment');

        // Redirect to the originally intended URL (or dashboard)
        $intended = session()->pull('url.intended', route('company.manager.dashboard'));

        return redirect($intended)->with('success', 'پرداخت با موفقیت انجام شد. اشتراک شما فعال شد.');
    }
}
