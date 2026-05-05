<?php

namespace App\Providers;

use App\Services\Sms\Contracts\SmsGatewayInterface;
use App\Services\Sms\Gateways\KavenegarGateway;
use App\Services\Sms\SmsService;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SmsGatewayInterface::class, KavenegarGateway::class);

        $this->app->singleton(SmsService::class, function ($app) {
            return new SmsService($app->make(SmsGatewayInterface::class));
        });
    }
}
