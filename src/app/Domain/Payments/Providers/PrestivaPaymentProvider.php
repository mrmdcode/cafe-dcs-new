<?php
namespace App\Domain\Payments\Providers;

use App\Domain\Payments\Contracts\PaymentProvider;
use App\Domain\Payments\DTO\PaymentRequest;
use App\Domain\Payments\DTO\PaymentResult;
use App\Domain\Payments\Exceptions\PaymentException;
use Illuminate\Support\Facades\Http;

class PrestivaPaymentProvider implements PaymentProvider
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $apiKey,
    ) {}

    public function initiate(PaymentRequest $request): PaymentResult
    {
        $response = $this->http()->post('/api/payments/initiate', [
            'amount'             => $request->amount,
            'description'        => $request->description,
            'callback_url'       => $request->callbackUrl,
            'external_reference' => $request->reference,
            'mobile'             => $request->mobile,
            'email'              => $request->email,
            'metadata'           => $request->metadata,
        ]);

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
        $response = $this->http()->get('/api/payments/status/' . $token);

        return $response->successful() && $response->json('status') === 'paid';
    }

    private function http()
    {
        return Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->withHeaders(['X-API-Key' => $this->apiKey]);
    }
}
