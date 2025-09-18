<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Departamento;
use App\Models\Provincia;

class CompaniesTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos departamentos y provincias para las empresas
        $lima = Departamento::where('nombre', 'Lima')->first();
        $limaProvince = $lima ? Provincia::where('departamento_id', $lima->id)->where('nombre', 'Lima')->first() : null;
        
        $arequipa = Departamento::where('nombre', 'Arequipa')->first();
        $arequipaProvince = $arequipa ? Provincia::where('departamento_id', $arequipa->id)->where('nombre', 'Arequipa')->first() : null;

        // Empresas de prueba para autocompletado
        $empresas = [
            [
                'ruc' => '20123456789',
                'razon_social' => 'Empresa Tecnológica Power GYMA S.A.C.',
                'telefono_fijo' => '01-4567890',
                'departamento_id' => $lima?->id,
                'provincia_id' => $limaProvince?->id,
                'direccion_calle' => 'Av. Javier Prado Este 123, San Isidro',
                'activo' => true,
            ],
            [
                'ruc' => '20987654321',
                'razon_social' => 'Comercializadora Los Andes E.I.R.L.',
                'telefono_fijo' => '054-123456',
                'departamento_id' => $arequipa?->id,
                'provincia_id' => $arequipaProvince?->id,
                'direccion_calle' => 'Calle Santa Catalina 456, Cercado',
                'activo' => true,
            ],
            [
                'ruc' => '20555666777',
                'razon_social' => 'Constructora Lima Norte S.A.',
                'telefono_fijo' => '01-2345678',
                'departamento_id' => $lima?->id,
                'provincia_id' => $limaProvince?->id,
                'direccion_calle' => 'Av. Túpac Amaru 789, Los Olivos',
                'activo' => true,
            ],
            [
                'ruc' => '20111222333',
                'razon_social' => 'Servicios Industriales del Perú S.A.C.',
                'telefono_fijo' => '01-9876543',
                'departamento_id' => $lima?->id,
                'provincia_id' => $limaProvince?->id,
                'direccion_calle' => 'Jr. Washington 321, Cercado de Lima',
                'activo' => true,
            ],
            [
                'ruc' => '20444555666',
                'razon_social' => 'Distribuidora Nacional de Equipos S.R.L.',
                'telefono_fijo' => '01-5555555',
                'departamento_id' => $lima?->id,
                'provincia_id' => $limaProvince?->id,
                'direccion_calle' => 'Av. Argentina 1234, Callao',
                'activo' => true,
            ],
        ];

        foreach ($empresas as $empresaData) {
            Company::updateOrCreate(
                ['ruc' => $empresaData['ruc']],
                $empresaData
            );
        }

        $this->command->info('✅ Empresas de prueba creadas exitosamente para autocompletado');
        $this->command->info('📋 RUCs de prueba:');
        $this->command->info('   • 20123456789 - Empresa Tecnológica Power GYMA S.A.C.');
        $this->command->info('   • 20987654321 - Comercializadora Los Andes E.I.R.L.');
        $this->command->info('   • 20555666777 - Constructora Lima Norte S.A.');
        $this->command->info('   • 20111222333 - Servicios Industriales del Perú S.A.C.');
        $this->command->info('   • 20444555666 - Distribuidora Nacional de Equipos S.R.L.');
    }
}