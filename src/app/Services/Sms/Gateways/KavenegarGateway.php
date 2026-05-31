<?php
namespace App\Services\Sms\Gateways;

use App\Services\Sms\Contracts\SmsGatewayInterface;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KavenegarGateway implements SmsGatewayInterface
{
    protected string $apiKey;

    protected string $baseUrl = 'https://api.kavenegar.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.kavenegar.key');

        if (empty($this->apiKey)) {
            throw new Exception('Kavenegar API key is not configured');
        }
    }

    public function send(string $phone, string $message, ?string $sender = null): bool
    {
        try {
            $sender = $sender ?? config('services.kavenegar.sender');

            $response = Http::get("{$this->baseUrl}/{$this->apiKey}/sms/send.json", [
                'receptor' => $phone,
                'sender'   => $sender,
                'message'  => $message,
            ]);

            $data = $response->json();

            if (isset($data['return']['status']) && $data['return']['status'] === 200) {
                Log::info('SMS sent', ['phone' => $phone, 'sender' => $sender]);
                return true;
            }

            Log::error('SMS failed', ['response' => $data]);
            return false;

        } catch (\Exception $e) {
            Log::error('SMS error', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Send verification code (lookup)
     */
    public function sendVerificationCode(string $phone, string $code, string $template = 'verify'): bool
    {
        try {
            $response = Http::get("{$this->baseUrl}/{$this->apiKey}/verify/lookup.json", [
                'receptor' => $phone,
                'token'    => $code,
                'template' => $template,
            ]);

            $data = $response->json();

            if (isset($data['return']['status']) && $data['return']['status'] === 200) {
                Log::info('Verification code sent', ['phone' => $phone]);
                return true;
            }

            Log::error('Verification failed', ['response' => $data]);
            return false;

        } catch (\Exception $e) {
            Log::error('Verification error', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Get account info (for admin)
     */
    public function getAccountInfo(): ?array
    {
        try {
            $response = Http::get("{$this->baseUrl}/{$this->apiKey}/account/info.json");
            $data     = $response->json();

            if (isset($data['return']['status']) && $data['return']['status'] === 200) {
                return [
                    'balance'     => $data['entries']['remaincredit'] ?? 0,
                    'expire_date' => $data['entries']['expiredate'] ?? null,
                    'type'        => $data['entries']['type'] ?? null,
                ];
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Get account info error', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
