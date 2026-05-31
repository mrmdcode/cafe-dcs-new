<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Registration = 'registration';
    case Cancelled = 'cancelled';
    case Edit = 'edit';
    case Finish = 'finish';
    case Paid = 'paid';

    // =========================
    // Persian labels
    // =========================
    public function label(): string
    {
        return match ($this) {

            self::Registration => 'ثبت سفارش',
            self::Cancelled => 'لغو شده',
            self::Edit => 'در حال ویرایش',
            self::Finish => 'اتمام آماده سازی',
            self::Paid => 'پرداخت شده',
        };
    }

    // =========================
    // Bootstrap colors
    // =========================
    public function color(): string
    {
        return match ($this) {
            self::Registration => 'secondary',
            self::Cancelled => 'danger',
            self::Edit => 'warning',
            self::Finish => 'primary',
            self::Paid => 'success',
        };
    }
}
