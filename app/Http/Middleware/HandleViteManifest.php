<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class HandleViteManifest
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Solo en producción y si no existe el manifest
        if (app()->environment('production')) {
            $manifestPath = public_path('build/manifest.json');
            
            if (!File::exists($manifestPath)) {
                Log::warning('Vite manifest not found, creating fallback');
                
                // Crear directorio si no existe
                $buildDir = dirname($manifestPath);
                if (!File::exists($buildDir)) {
                    File::makeDirectory($buildDir, 0755, true);
                }
                
                // Crear manifest básico de fallback
                $fallbackManifest = [
                    'resources/css/login.css' => [
                        'file' => 'assets/login.css',
                        'isEntry' => true,
                        'src' => 'resources/css/login.css'
                    ],
                    'resources/js/login.js' => [
                        'file' => 'assets/login.js',
                        'isEntry' => true,
                        'src' => 'resources/js/login.js'
                    ],
                    'resources/css/dashboard.css' => [
                        'file' => 'assets/dashboard.css',
                        'isEntry' => true,
                        'src' => 'resources/css/dashboard.css'
                    ],
                    'resources/js/chart-theme.js' => [
                        'file' => 'assets/chart-theme.js',
                        'isEntry' => true,
                        'src' => 'resources/js/chart-theme.js'
                    ],
                    'resources/css/app.css' => [
                        'file' => 'assets/app.css',
                        'isEntry' => true,
                        'src' => 'resources/css/app.css'
                    ],
                    'resources/js/app.js' => [
                        'file' => 'assets/app.js',
                        'isEntry' => true,
                        'src' => 'resources/js/app.js'
                    ]
                ];
                
                File::put($manifestPath, json_encode($fallbackManifest, JSON_PRETTY_PRINT));
                
                // También crear los directorios de assets si no existen
                $assetsDir = public_path('build/assets');
                if (!File::exists($assetsDir)) {
                    File::makeDirectory($assetsDir, 0755, true);
                }
                
                // Copiar archivos CSS y JS si existen en resources
                $this->copyResourceFiles();
            }
        }
        
        return $next($request);
    }
    
    /**
     * Copiar archivos de resources a build/assets como fallback
     */
    private function copyResourceFiles()
    {
        $resourcesPath = resource_path();
        $assetsPath = public_path('build/assets');
        
        // Copiar archivos CSS
        $cssFiles = File::glob($resourcesPath . '/css/*.css');
        foreach ($cssFiles as $file) {
            $filename = basename($file);
            File::copy($file, $assetsPath . '/' . $filename);
        }
        
        // Copiar archivos JS
        $jsFiles = File::glob($resourcesPath . '/js/*.js');
        foreach ($jsFiles as $file) {
            $filename = basename($file);
            File::copy($file, $assetsPath . '/' . $filename);
        }
    }
}
