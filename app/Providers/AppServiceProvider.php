<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar ExcelProcessorService
        $this->app->singleton(\App\Services\ExcelProcessorService::class, function ($app) {
            return new \App\Services\ExcelProcessorService();
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
