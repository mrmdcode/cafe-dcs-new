<?php
namespace App\Enums;

enum CompanySubscriptionStatus: string {
    case ACTIVE    = 'active';
    case EXPIRED   = 'expired';

    // === Label ===
    public function getLabel(): ?string
    {
        return match ($this) {
            self::ACTIVE    => __('Active'),
            self::EXPIRED   => __('Expired'),
        };
    }

    // === Color ===
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ACTIVE    => 'success',
            self::EXPIRED   => 'danger',
        };
    }

    // === Active Status Helper ===
    public function isActive(): bool
    {
        return in_array($this, [
            self::ACTIVE
        ]);
    }
}
