<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'force.https' => \App\Http\Middleware\ForceHttps::class,
            'vite.manifest' => \App\Http\Middleware\HandleViteManifest::class,
        ]);
        
        // Trust proxies for Railway/cloud platforms
        $middleware->trustProxies(at: '*');
        
        // Aplicar HTTPS middleware globalmente en producción
        if (($_ENV['APP_ENV'] ?? 'local') === 'production') {
            $middleware->web(prepend: [
                \App\Http\Middleware\TrustProxies::class,
                \App\Http\Middleware\ForceHttps::class,
                // Temporalmente comentado para debug
                // \App\Http\Middleware\HandleViteManifest::class,
            ]);
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
        
    })->create();
