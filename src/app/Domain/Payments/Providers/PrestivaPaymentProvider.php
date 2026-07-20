<?php
namespace App\Domain\Payments\Providers;

use App\Domain\Payments\Contracts\PaymentProvider;
use App\Domain\Payments\DTO\PaymentRequest;
use App\Domain\Payments\DTO\PaymentResult;
use App\Domain\Payments\Exceptions\PaymentException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrestivaPaymentProvider implements PaymentProvider
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiKey,
    ) {}

    public function initiate(PaymentRequest $request): PaymentResult
    {
        try {
            $response = $this->http()->post('/api/payments/initiate', [
                'amount'             => $request->amount,
                'description'        => $request->description,
                'callback_url'       => $request->callbackUrl,
                'external_reference' => $request->reference,
                'mobile'             => $request->mobile,
                'email'              => $request->email,
                'metadata'           => $request->metadata,
            ]);
        } catch (ConnectionException $e) {
            Log::error('payment.initiate.connection_failed', ['message' => $e->getMessage()]);
            throw new PaymentException('امکان اتصال به درگاه پرداخت وجود ندارد. لطفاً بعداً تلاش کنید.');
        }

        if (! $response->successful() || ! $response->json('success')) {
            throw new PaymentException($response->json('error') ?? 'Payment initiation failed.');
        }

        return new PaymentResult(
            token: $response->json('token'),
            payUrl: $response->json('payment_url'),
        );
    }

    public function isPaid(string $token): bool
    {
        try {
            $response = $this->http()->get('/api/payments/status/' . $token);
        } catch (ConnectionException $e) {
            Log::error('payment.status.connection_failed', ['message' => $e->getMessage()]);
            return false;
        }

        return $response->successful() && $response->json('status') === 'paid';
    }

    private function http()
    {
        return Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->timeout(5)
            ->connectTimeout(3)
            ->retry(2, 300)
            ->withOptions(['force_ip_resolve' => 'v4'])
            ->withHeaders(['X-API-Key' => $this->apiKey]);
    }
}
