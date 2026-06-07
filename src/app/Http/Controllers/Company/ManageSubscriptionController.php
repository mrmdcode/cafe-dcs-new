<?php
namespace App\Http\Controllers\Company;

use App\Enums\CompanySubscriptionStatus;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyPayment;
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

        if ($request->success !== 'true') {
            session()->forget('pending_payment');
            return redirect()->route('subscription.required')
                ->with('error', 'پرداخت توسط کاربر لغو شد.');
        }

        $statusResponse = Http::withOptions(['verify' => false])
            ->withHeaders(['X-API-Key' => config('services.company_manager.api_key')])
            ->get(config('services.company_manager.url') . '/api/payments/status/' . $pending['token']);

        if (! $statusResponse->successful() || $statusResponse->json('status') !== 'paid') {
            session()->forget('pending_payment');
            return redirect()->route('subscription.required')
                ->with('error', 'تأیید پرداخت ناموفق بود.');
        }

        DB::transaction(function () use ($pending, $statusResponse) {
            $companyId = $pending['company_id'];
            $company   = Company::find($companyId);
            $company->active();

            // Save payment record in Cafe DCS
            $payment = CompanyPayment::create([
                'company_id'     => $companyId,
                'payment_number' => 'PAY-' . $companyId . '-' . time(),
                'amount'         => $pending['amount'],
                'reference_id'   => $statusResponse->json('ref_id'),
                'status'         => 'paid',
                'paid_at'        => now(),
                'description'    => 'اشتراک ماهانه',
            ]);

            // Expire old subscriptions
            CompanySubscription::where('company_id', $companyId)
                ->where('status', CompanySubscriptionStatus::ACTIVE)
                ->update(['status' => CompanySubscriptionStatus::EXPIRED]);

            // Create new subscription linked to payment
            CompanySubscription::create([
                'company_id' => $companyId,
                'payment_id' => $payment->id, // ← link to local payment record
                'status'     => CompanySubscriptionStatus::ACTIVE,
                'starts_at'  => now(),
                'ends_at'    => now()->addDays($this->validDays),
            ]);
        });

        session()->forget('pending_payment');

        $intended = session()->pull('url.intended', route('company.manager.dashboard'));
        return redirect($intended)->with('success', 'پرداخت با موفقیت انجام شد. اشتراک شما فعال شد.');
    }

    public function webhook(Request $request)
    {
        if ($request->event === 'paid') {
            $company = Company::where('id', $request->external_reference)->first();

            if (! $company) {
                return response()->json(['error' => 'Company not found'], 404);
            }

            DB::transaction(function () use ($request, $company) {
                $payment = CompanyPayment::create([
                    'company_id'     => $company->id,
                    'amount'         => $request->amount,
                    'reference_id'   => $request->ref_id,
                    'payment_number' => 'PAY-' . $company->id . '-' . time(),
                    'status'         => 'paid',
                    'paid_at'        => now(),
                    'description'    => 'اشتراک ماهانه',
                ]);

                CompanySubscription::where('company_id', $company->id)
                    ->where('status', CompanySubscriptionStatus::ACTIVE)
                    ->update(['status' => CompanySubscriptionStatus::EXPIRED]);

                CompanySubscription::create([
                    'company_id' => $company->id,
                    'payment_id' => $payment->id,
                    'status'     => CompanySubscriptionStatus::ACTIVE,
                    'starts_at'  => now(),
                    'ends_at'    => now()->addDays($this->validDays),
                ]);

                $company->active();
            });
        }

        return response()->json(['received' => true]);
    }
}
