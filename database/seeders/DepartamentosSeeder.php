<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departamento;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentos = [
            ['nombre' => 'Amazonas', 'codigo' => '01'],
            ['nombre' => 'Áncash', 'codigo' => '02'],
            ['nombre' => 'Apurímac', 'codigo' => '03'],
            ['nombre' => 'Arequipa', 'codigo' => '04'],
            ['nombre' => 'Ayacucho', 'codigo' => '05'],
            ['nombre' => 'Cajamarca', 'codigo' => '06'],
            ['nombre' => 'Callao', 'codigo' => '07'],
            ['nombre' => 'Cusco', 'codigo' => '08'],
            ['nombre' => 'Huancavelica', 'codigo' => '09'],
            ['nombre' => 'Huánuco', 'codigo' => '10'],
            ['nombre' => 'Ica', 'codigo' => '11'],
            ['nombre' => 'Junín', 'codigo' => '12'],
            ['nombre' => 'La Libertad', 'codigo' => '13'],
            ['nombre' => 'Lambayeque', 'codigo' => '14'],
            ['nombre' => 'Lima', 'codigo' => '15'],
            ['nombre' => 'Loreto', 'codigo' => '16'],
            ['nombre' => 'Madre de Dios', 'codigo' => '17'],
            ['nombre' => 'Moquegua', 'codigo' => '18'],
            ['nombre' => 'Pasco', 'codigo' => '19'],
            ['nombre' => 'Piura', 'codigo' => '20'],
            ['nombre' => 'Puno', 'codigo' => '21'],
            ['nombre' => 'San Martín', 'codigo' => '22'],
            ['nombre' => 'Tacna', 'codigo' => '23'],
            ['nombre' => 'Tumbes', 'codigo' => '24'],
            ['nombre' => 'Ucayali', 'codigo' => '25'],
        ];

        foreach ($departamentos as $departamento) {
            Departamento::updateOrCreate(
                ['codigo' => $departamento['codigo']],
                [
                    'nombre' => $departamento['nombre'],
                    'activo' => true,
                ]
            );
        }

        $this->command->info('Se han insertado ' . count($departamentos) . ' departamentos del Perú.');
    }
}
