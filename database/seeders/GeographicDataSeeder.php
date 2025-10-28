<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GeographicDataSeeder extends Seeder
{
    /**
     * Seed the geographic data (Departamentos y Provincias).
     * Este seeder SOLO carga datos geográficos, nada más.
     */
    public function run(): void
    {
        $this->command->info('🗺️  C argando datos geográficos del Perú...');
        
        // Cargar departamentos (25 departamentos)
        $this->call(DepartamentosSeeder::class);
        
        // Cargar TODAS las provincias (incluyendo Madre de Dios y todas las demás)
        $this->call(ProvinciasSeeder::class);
        $this->call(ProvinciasCompletasSeeder::class);
        
        $this->command->info('✅ Datos geográficos cargados correctamente.');
    }
}
