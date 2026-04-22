<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BlockchainService;
use App\Services\CertificateService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BlockchainService::class);

        $this->app->singleton(CertificateService::class, function ($app) {
            return new CertificateService($app->make(BlockchainService::class));
        });
    }

    public function boot(): void
    {
        //
    }
}
