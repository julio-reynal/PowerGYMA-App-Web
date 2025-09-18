<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Provincia;
use App\Models\Departamento;

class ProvinciasCompletasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener los departamentos para mapear IDs
        $departamentos = Departamento::all()->keyBy('codigo');

        // TODAS las provincias del Perú organizadas por departamento
        $provincias = [
            // AYACUCHO (05) - LAS QUE FALTABAN
            ['departamento_codigo' => '05', 'nombre' => 'Huamanga', 'codigo' => '0501'],
            ['departamento_codigo' => '05', 'nombre' => 'Cangallo', 'codigo' => '0502'],
            ['departamento_codigo' => '05', 'nombre' => 'Huanca Sancos', 'codigo' => '0503'],
            ['departamento_codigo' => '05', 'nombre' => 'Huanta', 'codigo' => '0504'],
            ['departamento_codigo' => '05', 'nombre' => 'La Mar', 'codigo' => '0505'],
            ['departamento_codigo' => '05', 'nombre' => 'Lucanas', 'codigo' => '0506'],
            ['departamento_codigo' => '05', 'nombre' => 'Parinacochas', 'codigo' => '0507'],
            ['departamento_codigo' => '05', 'nombre' => 'Páucar del Sara Sara', 'codigo' => '0508'],
            ['departamento_codigo' => '05', 'nombre' => 'Sucre', 'codigo' => '0509'],
            ['departamento_codigo' => '05', 'nombre' => 'Víctor Fajardo', 'codigo' => '0510'],
            ['departamento_codigo' => '05', 'nombre' => 'Vilcas Huamán', 'codigo' => '0511'],

            // APURÍMAC (03)
            ['departamento_codigo' => '03', 'nombre' => 'Abancay', 'codigo' => '0301'],
            ['departamento_codigo' => '03', 'nombre' => 'Andahuaylas', 'codigo' => '0302'],
            ['departamento_codigo' => '03', 'nombre' => 'Antabamba', 'codigo' => '0303'],
            ['departamento_codigo' => '03', 'nombre' => 'Aymaraes', 'codigo' => '0304'],
            ['departamento_codigo' => '03', 'nombre' => 'Cotabambas', 'codigo' => '0305'],
            ['departamento_codigo' => '03', 'nombre' => 'Chincheros', 'codigo' => '0306'],
            ['departamento_codigo' => '03', 'nombre' => 'Grau', 'codigo' => '0307'],

            // CAJAMARCA (06)
            ['departamento_codigo' => '06', 'nombre' => 'Cajamarca', 'codigo' => '0601'],
            ['departamento_codigo' => '06', 'nombre' => 'Cajabamba', 'codigo' => '0602'],
            ['departamento_codigo' => '06', 'nombre' => 'Celendín', 'codigo' => '0603'],
            ['departamento_codigo' => '06', 'nombre' => 'Chota', 'codigo' => '0604'],
            ['departamento_codigo' => '06', 'nombre' => 'Contumazá', 'codigo' => '0605'],
            ['departamento_codigo' => '06', 'nombre' => 'Cutervo', 'codigo' => '0606'],
            ['departamento_codigo' => '06', 'nombre' => 'Hualgayoc', 'codigo' => '0607'],
            ['departamento_codigo' => '06', 'nombre' => 'Jaén', 'codigo' => '0608'],
            ['departamento_codigo' => '06', 'nombre' => 'San Ignacio', 'codigo' => '0609'],
            ['departamento_codigo' => '06', 'nombre' => 'San Marcos', 'codigo' => '0610'],
            ['departamento_codigo' => '06', 'nombre' => 'San Miguel', 'codigo' => '0611'],
            ['departamento_codigo' => '06', 'nombre' => 'San Pablo', 'codigo' => '0612'],
            ['departamento_codigo' => '06', 'nombre' => 'Santa Cruz', 'codigo' => '0613'],

            // HUANCAVELICA (09)
            ['departamento_codigo' => '09', 'nombre' => 'Huancavelica', 'codigo' => '0901'],
            ['departamento_codigo' => '09', 'nombre' => 'Acobamba', 'codigo' => '0902'],
            ['departamento_codigo' => '09', 'nombre' => 'Angaraes', 'codigo' => '0903'],
            ['departamento_codigo' => '09', 'nombre' => 'Castrovirreyna', 'codigo' => '0904'],
            ['departamento_codigo' => '09', 'nombre' => 'Churcampa', 'codigo' => '0905'],
            ['departamento_codigo' => '09', 'nombre' => 'Colcabamba', 'codigo' => '0906'],
            ['departamento_codigo' => '09', 'nombre' => 'Tayacaja', 'codigo' => '0907'],

            // HUÁNUCO (10)
            ['departamento_codigo' => '10', 'nombre' => 'Huánuco', 'codigo' => '1001'],
            ['departamento_codigo' => '10', 'nombre' => 'Ambo', 'codigo' => '1002'],
            ['departamento_codigo' => '10', 'nombre' => 'Dos de Mayo', 'codigo' => '1003'],
            ['departamento_codigo' => '10', 'nombre' => 'Huacaybamba', 'codigo' => '1004'],
            ['departamento_codigo' => '10', 'nombre' => 'Huamalíes', 'codigo' => '1005'],
            ['departamento_codigo' => '10', 'nombre' => 'Leoncio Prado', 'codigo' => '1006'],
            ['departamento_codigo' => '10', 'nombre' => 'Marañón', 'codigo' => '1007'],
            ['departamento_codigo' => '10', 'nombre' => 'Pachitea', 'codigo' => '1008'],
            ['departamento_codigo' => '10', 'nombre' => 'Puerto Inca', 'codigo' => '1009'],
            ['departamento_codigo' => '10', 'nombre' => 'Lauricocha', 'codigo' => '1010'],
            ['departamento_codigo' => '10', 'nombre' => 'Yarowilca', 'codigo' => '1011'],

            // LORETO (16)
            ['departamento_codigo' => '16', 'nombre' => 'Maynas', 'codigo' => '1601'],
            ['departamento_codigo' => '16', 'nombre' => 'Alto Amazonas', 'codigo' => '1602'],
            ['departamento_codigo' => '16', 'nombre' => 'Loreto', 'codigo' => '1603'],
            ['departamento_codigo' => '16', 'nombre' => 'Mariscal Ramón Castilla', 'codigo' => '1604'],
            ['departamento_codigo' => '16', 'nombre' => 'Requena', 'codigo' => '1605'],
            ['departamento_codigo' => '16', 'nombre' => 'Ucayali', 'codigo' => '1606'],
            ['departamento_codigo' => '16', 'nombre' => 'Datem del Marañón', 'codigo' => '1607'],
            ['departamento_codigo' => '16', 'nombre' => 'Putumayo', 'codigo' => '1608'],

            // MADRE DE DIOS (17)
            ['departamento_codigo' => '17', 'nombre' => 'Tambopata', 'codigo' => '1701'],
            ['departamento_codigo' => '17', 'nombre' => 'Manu', 'codigo' => '1702'],
            ['departamento_codigo' => '17', 'nombre' => 'Tahuamanu', 'codigo' => '1703'],

            // MOQUEGUA (18)
            ['departamento_codigo' => '18', 'nombre' => 'Mariscal Nieto', 'codigo' => '1801'],
            ['departamento_codigo' => '18', 'nombre' => 'General Sánchez Cerro', 'codigo' => '1802'],
            ['departamento_codigo' => '18', 'nombre' => 'Ilo', 'codigo' => '1803'],

            // PASCO (19)
            ['departamento_codigo' => '19', 'nombre' => 'Pasco', 'codigo' => '1901'],
            ['departamento_codigo' => '19', 'nombre' => 'Daniel Alcides Carrión', 'codigo' => '1902'],
            ['departamento_codigo' => '19', 'nombre' => 'Oxapampa', 'codigo' => '1903'],

            // PUNO (21)
            ['departamento_codigo' => '21', 'nombre' => 'Puno', 'codigo' => '2101'],
            ['departamento_codigo' => '21', 'nombre' => 'Azángaro', 'codigo' => '2102'],
            ['departamento_codigo' => '21', 'nombre' => 'Carabaya', 'codigo' => '2103'],
            ['departamento_codigo' => '21', 'nombre' => 'Chucuito', 'codigo' => '2104'],
            ['departamento_codigo' => '21', 'nombre' => 'El Collao', 'codigo' => '2105'],
            ['departamento_codigo' => '21', 'nombre' => 'Huancané', 'codigo' => '2106'],
            ['departamento_codigo' => '21', 'nombre' => 'Lampa', 'codigo' => '2107'],
            ['departamento_codigo' => '21', 'nombre' => 'Melgar', 'codigo' => '2108'],
            ['departamento_codigo' => '21', 'nombre' => 'Moho', 'codigo' => '2109'],
            ['departamento_codigo' => '21', 'nombre' => 'San Antonio de Putina', 'codigo' => '2110'],
            ['departamento_codigo' => '21', 'nombre' => 'San Román', 'codigo' => '2111'],
            ['departamento_codigo' => '21', 'nombre' => 'Sandia', 'codigo' => '2112'],
            ['departamento_codigo' => '21', 'nombre' => 'Yunguyo', 'codigo' => '2113'],

            // SAN MARTÍN (22)
            ['departamento_codigo' => '22', 'nombre' => 'Moyobamba', 'codigo' => '2201'],
            ['departamento_codigo' => '22', 'nombre' => 'Bellavista', 'codigo' => '2202'],
            ['departamento_codigo' => '22', 'nombre' => 'El Dorado', 'codigo' => '2203'],
            ['departamento_codigo' => '22', 'nombre' => 'Huallaga', 'codigo' => '2204'],
            ['departamento_codigo' => '22', 'nombre' => 'Lamas', 'codigo' => '2205'],
            ['departamento_codigo' => '22', 'nombre' => 'Mariscal Cáceres', 'codigo' => '2206'],
            ['departamento_codigo' => '22', 'nombre' => 'Picota', 'codigo' => '2207'],
            ['departamento_codigo' => '22', 'nombre' => 'Rioja', 'codigo' => '2208'],
            ['departamento_codigo' => '22', 'nombre' => 'San Martín', 'codigo' => '2209'],
            ['departamento_codigo' => '22', 'nombre' => 'Tocache', 'codigo' => '2210'],

            // TACNA (23)
            ['departamento_codigo' => '23', 'nombre' => 'Tacna', 'codigo' => '2301'],
            ['departamento_codigo' => '23', 'nombre' => 'Candarave', 'codigo' => '2302'],
            ['departamento_codigo' => '23', 'nombre' => 'Jorge Basadre', 'codigo' => '2303'],
            ['departamento_codigo' => '23', 'nombre' => 'Tarata', 'codigo' => '2304'],

            // TUMBES (24)
            ['departamento_codigo' => '24', 'nombre' => 'Tumbes', 'codigo' => '2401'],
            ['departamento_codigo' => '24', 'nombre' => 'Contralmirante Villar', 'codigo' => '2402'],
            ['departamento_codigo' => '24', 'nombre' => 'Zarumilla', 'codigo' => '2403'],

            // UCAYALI (25)
            ['departamento_codigo' => '25', 'nombre' => 'Coronel Portillo', 'codigo' => '2501'],
            ['departamento_codigo' => '25', 'nombre' => 'Atalaya', 'codigo' => '2502'],
            ['departamento_codigo' => '25', 'nombre' => 'Padre Abad', 'codigo' => '2503'],
            ['departamento_codigo' => '25', 'nombre' => 'Purús', 'codigo' => '2504'],
        ];

        foreach ($provincias as $provincia) {
            $departamento = $departamentos->get($provincia['departamento_codigo']);
            
            if ($departamento) {
                Provincia::updateOrCreate(
                    ['codigo' => $provincia['codigo']],
                    [
                        'departamento_id' => $departamento->id,
                        'nombre' => $provincia['nombre'],
                        'activo' => true,
                    ]
                );
            }
        }

        $this->command->info('Se han insertado ' . count($provincias) . ' provincias faltantes del Perú.');
    }
}
