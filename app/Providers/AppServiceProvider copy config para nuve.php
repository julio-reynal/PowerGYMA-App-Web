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
        // Configuración HTTPS SOLO para producción (NO para local/development)
        if (config('app.env') === 'production') {
            // Forzar HTTPS para URLs
            URL::forceScheme('https');
            
            // Configurar servidor para HTTPS
            $this->app['request']->server->set('HTTPS', true);
            $this->app['request']->server->set('SERVER_PORT', 443);
            $this->app['request']->server->set('HTTP_X_FORWARDED_PROTO', 'https');
            
            // Configurar URL root
            if (config('app.url')) {
                URL::forceRootUrl(config('app.url'));
            }
        }
    }
}
