<?php
namespace App\Domain\Payments\Contracts;

use App\Domain\Payments\DTO\PaymentRequest;
use App\Domain\Payments\DTO\PaymentResult;

/**
 * Whatever actually processes payments — today it's Prestiva's shared
 * gateway, later it could be a gateway this product owns directly.
 * The rest of the app only depends on this interface.
 */
interface PaymentProvider
{
    public function initiate(PaymentRequest $request): PaymentResult;

    public function isPaid(string $token): bool;
}
