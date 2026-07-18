<?php
namespace App\Domain\Payments\DTO;

final class PaymentResult
{
    public function __construct(
        public readonly string $token,
        public readonly string $payUrl,
    ) {}
}
