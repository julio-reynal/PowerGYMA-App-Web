<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'force.https' => \App\Http\Middleware\ForceHttps::class,
        ]);
        
        // Trust proxies for Railway/cloud platforms
        $middleware->trustProxies(at: '*');
        
        // Aplicar HTTPS middleware globalmente en producción
        if (config('app.env') === 'production') {
            $middleware->web(prepend: [
                \App\Http\Middleware\TrustProxies::class,
                \App\Http\Middleware\ForceHttps::class,
            ]);
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
        
    })->create();
