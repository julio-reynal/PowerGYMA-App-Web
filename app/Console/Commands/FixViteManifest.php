<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixViteManifest extends Command
{
    protected $signature = 'vite:fix-manifest {--force : Force recreation of manifest}';
    protected $description = 'Fix or create Vite manifest for production';

    public function handle()
    {
        $manifestPath = public_path('build/manifest.json');
        $buildDir = public_path('build');
        $assetsDir = public_path('build/assets');

        $this->info('🔧 Fixing Vite manifest...');

        // Crear directorios si no existen
        if (!File::exists($buildDir)) {
            File::makeDirectory($buildDir, 0755, true);
            $this->info('✅ Created build directory');
        }

        if (!File::exists($assetsDir)) {
            File::makeDirectory($assetsDir, 0755, true);
            $this->info('✅ Created assets directory');
        }

        // Verificar si ya existe el manifest y no se fuerza
        if (File::exists($manifestPath) && !$this->option('force')) {
            $this->info('ℹ️  Manifest already exists. Use --force to recreate.');
            return 0;
        }

        // Crear manifest de fallback
        $manifest = [
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
            ],
            'resources/css/index.css' => [
                'file' => 'assets/index.css',
                'isEntry' => true,
                'src' => 'resources/css/index.css'
            ],
            'resources/js/index.js' => [
                'file' => 'assets/index.js',
                'isEntry' => true,
                'src' => 'resources/js/index.js'
            ],
            'resources/css/auth.css' => [
                'file' => 'assets/auth.css',
                'isEntry' => true,
                'src' => 'resources/css/auth.css'
            ],
            'resources/js/auth.js' => [
                'file' => 'assets/auth.js',
                'isEntry' => true,
                'src' => 'resources/js/auth.js'
            ]
        ];

        // Escribir manifest
        File::put($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->info('✅ Manifest created/updated');

        // Copiar archivos de resources a assets
        $this->copyResourceFiles();

        $this->info('🎉 Vite manifest fix completed successfully!');
        return 0;
    }

    private function copyResourceFiles()
    {
        $resourcesPath = resource_path();
        $assetsPath = public_path('build/assets');

        // Copiar archivos CSS
        $cssPath = $resourcesPath . '/css';
        if (File::exists($cssPath)) {
            $cssFiles = File::glob($cssPath . '/*.css');
            foreach ($cssFiles as $file) {
                $filename = basename($file);
                File::copy($file, $assetsPath . '/' . $filename);
                $this->info("📄 Copied CSS: {$filename}");
            }
        }

        // Copiar archivos JS
        $jsPath = $resourcesPath . '/js';
        if (File::exists($jsPath)) {
            $jsFiles = File::glob($jsPath . '/*.js');
            foreach ($jsFiles as $file) {
                $filename = basename($file);
                File::copy($file, $assetsPath . '/' . $filename);
                $this->info("📄 Copied JS: {$filename}");
            }
        }
    }
}
