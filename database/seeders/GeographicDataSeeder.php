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
        $this->command->info('🗺️  Cargando datos geográficos del Perú...');
        
        // Cargar departamentos
        $this->call(DepartamentosSeeder::class);
        
        // Cargar provincias
        $this->call(ProvinciasSeeder::class);
        
        $this->command->info('✅ Datos geográficos cargados correctamente.');
    }
}
