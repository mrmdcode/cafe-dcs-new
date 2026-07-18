<?php
namespace App\Http\Controllers\Company;

use App\Domain\Payments\Contracts\PaymentProvider;
use App\Domain\Payments\DTO\PaymentRequest;
use App\Domain\Payments\Exceptions\PaymentException;
use App\Enums\CompanySubscriptionStatus;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyPayment;
use App\Models\CompanySubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageSubscriptionController extends Controller
{
    protected int $validDays = 30;

    public function __construct(private readonly PaymentProvider $payments) {}

    public function showPaymentPage()
    {
        $company = Auth::user()->company;

        if (! $company || ! $company->fee_received) {
            abort(403, 'شرکت شما تعرفه‌ای تعیین نکرده است.');
        }

        return view('dashboard.company.manager.subscription', [
            'amount' => (int) $company->fee_received,
        ]);
    }

    public function requestPayment(Request $request)
    {
        $user    = Auth::user();
        $company = $user?->company;

        if (! $user || ! $company) {
            return redirect()->route('dashboard')->with('error', 'Company not found.');
        }

        $amount = (int) $company->fee_received;

        try {
            $result = $this->payments->initiate(new PaymentRequest(
                amount: $amount,
                description: 'اشتراک ماهانه - ' . $company->name,
                callbackUrl: route('subscription.callback'),
                reference: 'cafe_dcs:company:' . $user->company_id,
                mobile: $user->mobile,
                email: $user->email,
                metadata: ['company_id' => $user->company_id, 'reason' => 'monthly_subscription'],
            ));
        } catch (PaymentException $e) {
            return back()->with('error', 'خطا در اتصال به درگاه پرداخت: ' . $e->getMessage());
        }

        session()->put('pending_payment', [
            'token'      => $result->token,
            'amount'     => $amount,
            'company_id' => $user->company_id,
        ]);

        return redirect()->away($result->payUrl);
    }

    public function callback(Request $request)
    {
        $pending = session()->get('pending_payment');

        if (! $pending || $request->success !== 'true') {
            session()->forget('pending_payment');
            return redirect()->route('subscription.required')->with('error', 'پرداخت ناموفق بود.');
        }

        if (! $this->payments->isPaid($pending['token'])) {
            session()->forget('pending_payment');
            return redirect()->route('subscription.required')->with('error', 'تأیید پرداخت ناموفق بود.');
        }

        $this->activateSubscription($pending['company_id'], $pending['amount']);
        session()->forget('pending_payment');

        $intended = session()->pull('url.intended', route('company.manager.dashboard'));
        return redirect($intended)->with('success', 'پرداخت با موفقیت انجام شد. اشتراک شما فعال شد.');
    }

    public function webhook(Request $request)
    {
        if ($request->event === 'paid') {
            $companyId = last(explode(':', $request->external_reference));

            if (! Company::find($companyId)) {
                return response()->json(['error' => 'Company not found'], 404);
            }

            $this->activateSubscription($companyId, $request->amount);
        }

        return response()->json(['received' => true]);
    }

    private function activateSubscription(int $companyId, int $amount): void
    {
        DB::transaction(function () use ($companyId, $amount) {
            $company = Company::findOrFail($companyId);

            $payment = CompanyPayment::create([
                'company_id'     => $companyId,
                'payment_number' => 'PAY-' . $companyId . '-' . time(),
                'amount'         => $amount,
                'status'         => 'paid',
                'paid_at'        => now(),
                'description'    => 'اشتراک ماهانه',
            ]);

            CompanySubscription::where('company_id', $companyId)
                ->where('status', CompanySubscriptionStatus::ACTIVE)
                ->update(['status' => CompanySubscriptionStatus::EXPIRED]);

            CompanySubscription::create([
                'company_id' => $companyId,
                'payment_id' => $payment->id,
                'status'     => CompanySubscriptionStatus::ACTIVE,
                'starts_at'  => now(),
                'ends_at'    => now()->addDays($this->validDays),
            ]);

            $company->active();
        });
    }
}
