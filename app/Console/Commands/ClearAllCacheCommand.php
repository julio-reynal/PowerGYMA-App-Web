<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class ClearAllCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar toda la caché de la aplicación';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Limpiando toda la caché de la aplicación...');
        
        // Limpiar caché de aplicación
        $this->info('Limpiando caché de aplicación...');
        Cache::flush();
        
        // Limpiar caché de configuración
        $this->info('Limpiando caché de configuración...');
        Artisan::call('config:clear');
        
        // Limpiar caché de rutas
        $this->info('Limpiando caché de rutas...');
        Artisan::call('route:clear');
        
        // Limpiar caché de vistas
        $this->info('Limpiando caché de vistas...');
        Artisan::call('view:clear');
        
        // Limpiar caché de eventos
        $this->info('Limpiando caché de eventos...');
        Artisan::call('event:clear');
        
        // Refrescar la caché del dashboard demo
        $this->info('Refrescando caché del dashboard demo...');
        Artisan::call('demo:refresh-dashboard');
        
        $this->info('¡Toda la caché ha sido limpiada exitosamente!');
        
        return 0;
    }
}
