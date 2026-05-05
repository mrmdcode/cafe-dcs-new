<?php
namespace App\Services;

use App\Enums\CompanySubscriptionStatus;
use App\Models\Company;
use App\Models\CompanySubscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SubscriptionService
{
    protected static function getUser(?User $user = null): ?User
    {
        return $user ?? Auth::user();
    }

    public static function hasActiveSubscription(?User $user = null): bool
    {
        return self::getActiveSubscription($user) !== null;
    }

    public static function getActiveSubscription(?User $user = null): ?CompanySubscription
    {
        $user = self::getUser($user);
        if (! $user || ! $user->company_id) {
            return null;
        }

        $company = Company::find($user->company_id);
        if (! $company) {
            return null;
        }

        return $company->subscriptions()
            ->where('status', CompanySubscriptionStatus::ACTIVE)
            ->where(function ($query) {
                $query->where('ends_at', '>', now())
                    ->orWhereNull('ends_at'); // for lifetime subscriptions
            })
            ->first();
    }
}
