<?php
namespace App\Providers;

use App\Domain\Payments\Contracts\PaymentProvider;
use App\Domain\Payments\Providers\PrestivaPaymentProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentProvider::class, fn() => new PrestivaPaymentProvider(
            baseUrl: config('payments.base_url'),
            apiKey: config('payments.api_key'),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        # force requests to https for looping problem in login process
        \Illuminate\Support\Facades\URL::forceScheme('https');
    }
}
