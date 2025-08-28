<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ClienteService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ClienteService::class, function ($app) {
            return new ClienteService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
