<?php
namespace App\Http\Controllers\Company;

use App\Enums\CompanySubscriptionStatus;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanySubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ManageSubscriptionController extends Controller
{
    protected int $validDays = 30; // subscription duration in days

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

        $amount = (int) $company->fee_received;
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

        $response = Http::acceptJson()->withHeaders([
            'X-API-Key' => config('services.company_manager.api_key'),
        ])->withOptions([
            'verify' => false,
        ])->post(config('services.company_manager.url') . '/api/payments/initiate', [
            'company_id'   => $user->company_id,
            'amount'       => $amount,
            'description'  => $description,
            'callback_url' => route('subscription.callback'),
            'mobile'       => $user->mobile ?? null,
            'email'        => $user->email ?? null,
        ]);

        if (! $response->successful() || ! $response->json('success')) {
            return back()->with('error', 'خطا در اتصال به درگاه پرداخت: ' . $response->json('error', 'Unknown error'));
        }

        // Store token instead of authority — token is our verification key
        session()->put('pending_payment', [
            'token'      => $response->json('token'),
            'amount'     => $amount,
            'company_id' => $user->company_id,
        ]);

        return redirect()->away($response->json('payment_url'));
    }

    /**
     * Callback from Zarinpal after user attempts to pay.
     */
    public function callback(Request $request)
    {
        $pending = session()->get('pending_payment');

        if (! $pending) {
            return redirect()->route('subscription.required')
                ->with('error', 'اطلاعات پرداخت نامعتبر است.');
        }

        // Payment was cancelled
        if ($request->success !== 'true') {
            session()->forget('pending_payment');
            return redirect()->route('subscription.required')
                ->with('error', 'پرداخت توسط کاربر لغو شد.');
        }

        // Double-check with Company Manager status endpoint
        $response = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'X-API-Key' => config('services.company_manager.api_key'),
        ])->get(config('services.company_manager.url') . '/api/payments/status/' . $pending['token']);

        if (! $response->successful() || $response->json('status') !== 'paid') {
            session()->forget('pending_payment');
            return redirect()->route('subscription.required')
                ->with('error', 'تأیید پرداخت ناموفق بود.');
        }

        // Payment confirmed — activate subscription
        DB::transaction(function () use ($pending, $response) {
            $companyId = $pending['company_id'];
            $company   = Company::find($companyId);
            $company->active();

            CompanySubscription::where('company_id', $companyId)
                ->where('status', CompanySubscriptionStatus::ACTIVE)
                ->update(['status' => CompanySubscriptionStatus::EXPIRED]);

            CompanySubscription::create([
                'company_id'  => $companyId,
                'status'      => CompanySubscriptionStatus::ACTIVE,
                'starts_at'   => now(),
                'ends_at'     => now()->addDays($this->validDays),
                'payment_ref' => $response->json('ref_id'),
            ]);
        });

        session()->forget('pending_payment');

        $intended = session()->pull('url.intended', route('company.manager.dashboard'));
        return redirect($intended)->with('success', 'پرداخت با موفقیت انجام شد. اشتراک شما فعال شد.');
    }
}
