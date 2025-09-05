<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Forzar HTTPS en producción
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        // Configurar URL root si está definida
        if (config('app.url')) {
            URL::forceRootUrl(config('app.url'));
        }
    }
}
