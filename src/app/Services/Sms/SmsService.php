<?php
namespace App\Services\Sms;

use App\Services\Sms\Contracts\SmsGatewayInterface;

class SmsService
{
    public function __construct(protected SmsGatewayInterface $gateway)
    {}

    /**
     * Send a plain text SMS.
     */
    public function send(string $phone, string $message, ?string $sender = null): bool
    {
        return $this->gateway->send($phone, $message, $sender);
    }
}
