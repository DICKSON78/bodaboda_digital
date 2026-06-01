<?php

namespace App\Providers;

use App\Services\MqttService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MqttService::class, function () {
            return new MqttService();
        });
    }

    public function boot(): void
    {
        //
    }
}
