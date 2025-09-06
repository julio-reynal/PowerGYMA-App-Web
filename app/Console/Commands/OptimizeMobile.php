<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeMobile extends Command
{
    protected $signature = 'mobile:optimize';
    protected $description = 'Optimiza la aplicación para dispositivos móviles';

    public function handle()
    {
        $this->info('🚀 Optimizando aplicación para móviles...');

        // Verificar viewport tags
        $this->checkViewportTags();
        
        // Optimizar imágenes
        $this->optimizeImages();
        
        // Verificar CSS responsive
        $this->checkResponsiveCSS();
        
        // Generar manifest PWA básico
        $this->generateBasicManifest();

        $this->info('✅ Optimización móvil completada!');
        
        return 0;
    }

    private function checkViewportTags()
    {
        $this->info('📱 Verificando viewport tags...');
        
        $files = [
            'resources/views/index.blade.php',
            'resources/views/auth/login.blade.php',
            'resources/views/layouts/dashboard.blade.php'
        ];
        
        foreach ($files as $file) {
            if (file_exists(base_path($file))) {
                $content = file_get_contents(base_path($file));
                if (strpos($content, 'viewport') !== false) {
                    $this->line("✅ {$file} tiene viewport tag");
                } else {
                    $this->warn("⚠️  {$file} NO tiene viewport tag");
                }
            }
        }
    }

    private function optimizeImages()
    {
        $this->info('🖼️  Verificando imágenes...');
        
        $imgDir = public_path('Img');
        if (is_dir($imgDir)) {
            $this->line("✅ Directorio de imágenes encontrado: {$imgDir}");
        } else {
            $this->warn("⚠️  Directorio de imágenes no encontrado");
        }
    }

    private function checkResponsiveCSS()
    {
        $this->info('📐 Verificando CSS responsive...');
        
        $cssFiles = [
            'resources/css/index.css',
            'resources/css/dashboard.css',
            'resources/css/login.css'
        ];
        
        foreach ($cssFiles as $file) {
            if (file_exists(base_path($file))) {
                $content = file_get_contents(base_path($file));
                $mediaQueries = substr_count($content, '@media');
                $this->line("✅ {$file} tiene {$mediaQueries} media queries");
            }
        }
    }

    private function generateBasicManifest()
    {
        $this->info('📄 Generando manifest PWA básico...');
        
        $manifest = [
            "name" => "Power GYMA",
            "short_name" => "PowerGYMA",
            "description" => "Sistema de Gestión y Monitoreo de Energía",
            "start_url" => "/",
            "display" => "standalone",
            "theme_color" => "#667eea",
            "background_color" => "#667eea",
            "orientation" => "portrait-primary",
            "icons" => [
                [
                    "src" => "/Img/Ico/Ico-Pw.svg",
                    "sizes" => "192x192",
                    "type" => "image/svg+xml"
                ]
            ]
        ];
        
        file_put_contents(
            public_path('manifest.json'), 
            json_encode($manifest, JSON_PRETTY_PRINT)
        );
        
        $this->line("✅ Manifest PWA creado en public/manifest.json");
    }
}
