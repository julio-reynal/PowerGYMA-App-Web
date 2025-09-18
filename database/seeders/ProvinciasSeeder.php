<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Provincia;
use App\Models\Departamento;

class ProvinciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener los departamentos para mapear IDs
        $departamentos = Departamento::all()->keyBy('codigo');

        // Definir las principales provincias por departamento (las más importantes de cada uno)
        $provincias = [
            // Lima (15)
            ['departamento_codigo' => '15', 'nombre' => 'Lima', 'codigo' => '1501'],
            ['departamento_codigo' => '15', 'nombre' => 'Barranca', 'codigo' => '1502'],
            ['departamento_codigo' => '15', 'nombre' => 'Cajatambo', 'codigo' => '1503'],
            ['departamento_codigo' => '15', 'nombre' => 'Canta', 'codigo' => '1504'],
            ['departamento_codigo' => '15', 'nombre' => 'Cañete', 'codigo' => '1505'],
            ['departamento_codigo' => '15', 'nombre' => 'Huaral', 'codigo' => '1506'],
            ['departamento_codigo' => '15', 'nombre' => 'Huarochirí', 'codigo' => '1507'],
            ['departamento_codigo' => '15', 'nombre' => 'Huaura', 'codigo' => '1508'],
            ['departamento_codigo' => '15', 'nombre' => 'Oyón', 'codigo' => '1509'],
            ['departamento_codigo' => '15', 'nombre' => 'Yauyos', 'codigo' => '1510'],

            // Arequipa (04)
            ['departamento_codigo' => '04', 'nombre' => 'Arequipa', 'codigo' => '0401'],
            ['departamento_codigo' => '04', 'nombre' => 'Camaná', 'codigo' => '0402'],
            ['departamento_codigo' => '04', 'nombre' => 'Caravelí', 'codigo' => '0403'],
            ['departamento_codigo' => '04', 'nombre' => 'Castilla', 'codigo' => '0404'],
            ['departamento_codigo' => '04', 'nombre' => 'Caylloma', 'codigo' => '0405'],
            ['departamento_codigo' => '04', 'nombre' => 'Condesuyos', 'codigo' => '0406'],
            ['departamento_codigo' => '04', 'nombre' => 'Islay', 'codigo' => '0407'],
            ['departamento_codigo' => '04', 'nombre' => 'La Unión', 'codigo' => '0408'],

            // La Libertad (13)
            ['departamento_codigo' => '13', 'nombre' => 'Trujillo', 'codigo' => '1301'],
            ['departamento_codigo' => '13', 'nombre' => 'Ascope', 'codigo' => '1302'],
            ['departamento_codigo' => '13', 'nombre' => 'Bolívar', 'codigo' => '1303'],
            ['departamento_codigo' => '13', 'nombre' => 'Chepén', 'codigo' => '1304'],
            ['departamento_codigo' => '13', 'nombre' => 'Julcán', 'codigo' => '1305'],
            ['departamento_codigo' => '13', 'nombre' => 'Otuzco', 'codigo' => '1306'],
            ['departamento_codigo' => '13', 'nombre' => 'Pacasmayo', 'codigo' => '1307'],
            ['departamento_codigo' => '13', 'nombre' => 'Pataz', 'codigo' => '1308'],
            ['departamento_codigo' => '13', 'nombre' => 'Sánchez Carrión', 'codigo' => '1309'],
            ['departamento_codigo' => '13', 'nombre' => 'Santiago de Chuco', 'codigo' => '1310'],
            ['departamento_codigo' => '13', 'nombre' => 'Gran Chimú', 'codigo' => '1311'],
            ['departamento_codigo' => '13', 'nombre' => 'Virú', 'codigo' => '1312'],

            // Piura (20)
            ['departamento_codigo' => '20', 'nombre' => 'Piura', 'codigo' => '2001'],
            ['departamento_codigo' => '20', 'nombre' => 'Ayabaca', 'codigo' => '2002'],
            ['departamento_codigo' => '20', 'nombre' => 'Huancabamba', 'codigo' => '2003'],
            ['departamento_codigo' => '20', 'nombre' => 'Morropón', 'codigo' => '2004'],
            ['departamento_codigo' => '20', 'nombre' => 'Paita', 'codigo' => '2005'],
            ['departamento_codigo' => '20', 'nombre' => 'Sullana', 'codigo' => '2006'],
            ['departamento_codigo' => '20', 'nombre' => 'Talara', 'codigo' => '2007'],
            ['departamento_codigo' => '20', 'nombre' => 'Sechura', 'codigo' => '2008'],

            // Lambayeque (14)
            ['departamento_codigo' => '14', 'nombre' => 'Chiclayo', 'codigo' => '1401'],
            ['departamento_codigo' => '14', 'nombre' => 'Ferreñafe', 'codigo' => '1402'],
            ['departamento_codigo' => '14', 'nombre' => 'Lambayeque', 'codigo' => '1403'],

            // Callao (07)
            ['departamento_codigo' => '07', 'nombre' => 'Callao', 'codigo' => '0701'],

            // Cusco (08)
            ['departamento_codigo' => '08', 'nombre' => 'Cusco', 'codigo' => '0801'],
            ['departamento_codigo' => '08', 'nombre' => 'Acomayo', 'codigo' => '0802'],
            ['departamento_codigo' => '08', 'nombre' => 'Anta', 'codigo' => '0803'],
            ['departamento_codigo' => '08', 'nombre' => 'Calca', 'codigo' => '0804'],
            ['departamento_codigo' => '08', 'nombre' => 'Canas', 'codigo' => '0805'],
            ['departamento_codigo' => '08', 'nombre' => 'Canchis', 'codigo' => '0806'],
            ['departamento_codigo' => '08', 'nombre' => 'Chumbivilcas', 'codigo' => '0807'],
            ['departamento_codigo' => '08', 'nombre' => 'Espinar', 'codigo' => '0808'],
            ['departamento_codigo' => '08', 'nombre' => 'La Convención', 'codigo' => '0809'],
            ['departamento_codigo' => '08', 'nombre' => 'Paruro', 'codigo' => '0810'],
            ['departamento_codigo' => '08', 'nombre' => 'Paucartambo', 'codigo' => '0811'],
            ['departamento_codigo' => '08', 'nombre' => 'Quispicanchi', 'codigo' => '0812'],
            ['departamento_codigo' => '08', 'nombre' => 'Urubamba', 'codigo' => '0813'],

            // Junín (12)
            ['departamento_codigo' => '12', 'nombre' => 'Huancayo', 'codigo' => '1201'],
            ['departamento_codigo' => '12', 'nombre' => 'Concepción', 'codigo' => '1202'],
            ['departamento_codigo' => '12', 'nombre' => 'Chanchamayo', 'codigo' => '1203'],
            ['departamento_codigo' => '12', 'nombre' => 'Jauja', 'codigo' => '1204'],
            ['departamento_codigo' => '12', 'nombre' => 'Junín', 'codigo' => '1205'],
            ['departamento_codigo' => '12', 'nombre' => 'Satipo', 'codigo' => '1206'],
            ['departamento_codigo' => '12', 'nombre' => 'Tarma', 'codigo' => '1207'],
            ['departamento_codigo' => '12', 'nombre' => 'Yauli', 'codigo' => '1208'],
            ['departamento_codigo' => '12', 'nombre' => 'Chupaca', 'codigo' => '1209'],

            // Ica (11)
            ['departamento_codigo' => '11', 'nombre' => 'Ica', 'codigo' => '1101'],
            ['departamento_codigo' => '11', 'nombre' => 'Chincha', 'codigo' => '1102'],
            ['departamento_codigo' => '11', 'nombre' => 'Nazca', 'codigo' => '1103'],
            ['departamento_codigo' => '11', 'nombre' => 'Palpa', 'codigo' => '1104'],
            ['departamento_codigo' => '11', 'nombre' => 'Pisco', 'codigo' => '1105'],

            // Áncash (02)
            ['departamento_codigo' => '02', 'nombre' => 'Huaraz', 'codigo' => '0201'],
            ['departamento_codigo' => '02', 'nombre' => 'Aija', 'codigo' => '0202'],
            ['departamento_codigo' => '02', 'nombre' => 'Antonio Raymondi', 'codigo' => '0203'],
            ['departamento_codigo' => '02', 'nombre' => 'Asunción', 'codigo' => '0204'],
            ['departamento_codigo' => '02', 'nombre' => 'Bolognesi', 'codigo' => '0205'],
            ['departamento_codigo' => '02', 'nombre' => 'Carhuaz', 'codigo' => '0206'],
            ['departamento_codigo' => '02', 'nombre' => 'Carlos Fermín Fitzcarrald', 'codigo' => '0207'],
            ['departamento_codigo' => '02', 'nombre' => 'Casma', 'codigo' => '0208'],
            ['departamento_codigo' => '02', 'nombre' => 'Corongo', 'codigo' => '0209'],
            ['departamento_codigo' => '02', 'nombre' => 'Huari', 'codigo' => '0210'],
            ['departamento_codigo' => '02', 'nombre' => 'Huarmey', 'codigo' => '0211'],
            ['departamento_codigo' => '02', 'nombre' => 'Huaylas', 'codigo' => '0212'],
            ['departamento_codigo' => '02', 'nombre' => 'Mariscal Luzuriaga', 'codigo' => '0213'],
            ['departamento_codigo' => '02', 'nombre' => 'Ocros', 'codigo' => '0214'],
            ['departamento_codigo' => '02', 'nombre' => 'Pallasca', 'codigo' => '0215'],
            ['departamento_codigo' => '02', 'nombre' => 'Pomabamba', 'codigo' => '0216'],
            ['departamento_codigo' => '02', 'nombre' => 'Recuay', 'codigo' => '0217'],
            ['departamento_codigo' => '02', 'nombre' => 'Santa', 'codigo' => '0218'],
            ['departamento_codigo' => '02', 'nombre' => 'Sihuas', 'codigo' => '0219'],
            ['departamento_codigo' => '02', 'nombre' => 'Yungay', 'codigo' => '0220'],

            // Resto de departamentos con sus provincias principales (agregando las más importantes)
            ['departamento_codigo' => '01', 'nombre' => 'Chachapoyas', 'codigo' => '0101'],
            ['departamento_codigo' => '01', 'nombre' => 'Bagua', 'codigo' => '0102'],
            ['departamento_codigo' => '01', 'nombre' => 'Bongará', 'codigo' => '0103'],
            ['departamento_codigo' => '01', 'nombre' => 'Condorcanqui', 'codigo' => '0104'],
            ['departamento_codigo' => '01', 'nombre' => 'Luya', 'codigo' => '0105'],
            ['departamento_codigo' => '01', 'nombre' => 'Rodríguez de Mendoza', 'codigo' => '0106'],
            ['departamento_codigo' => '01', 'nombre' => 'Utcubamba', 'codigo' => '0107'],
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

        $this->command->info('Se han insertado ' . count($provincias) . ' provincias principales del Perú.');
    }
}
