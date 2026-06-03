<?php

namespace App\Providers;

use App\Services\FeatureGateService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FeatureGateService::class, function () {
            return new FeatureGateService();
        });
    }

    public function boot(): void
    {
        //
    }
}
