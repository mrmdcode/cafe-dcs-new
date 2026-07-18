<?php
namespace App\Domain\Payments\DTO;

final class PaymentRequest
{
    public function __construct(
        public readonly int $amount,
        public readonly string $description,
        public readonly string $callbackUrl,
        public readonly string $reference,   // our own identifier, e.g. "company:42"
        public readonly ?string $mobile = null,
        public readonly ?string $email = null,
        public readonly array $metadata = [],
    ) {}
}
