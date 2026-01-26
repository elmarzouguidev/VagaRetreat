<?php

namespace App\Providers;

use App\Services\CurrencyConversionService;
use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CurrencyConversionService::class, function ($app) {
            return new CurrencyConversionService();
        });

        // Register helper
        $this->app->bind('currency', function ($app) {
            return $app->make(CurrencyConversionService::class);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
               \App\Console\Commands\RefreshExchangeRates::class,
            ]);
        }
    }
}
