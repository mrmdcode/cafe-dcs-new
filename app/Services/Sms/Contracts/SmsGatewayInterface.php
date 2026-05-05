<?php
namespace App\Services\Sms\Contracts;

interface SmsGatewayInterface
{
    public function send(string $phone, string $message, ?string $sender = null): bool;
}
