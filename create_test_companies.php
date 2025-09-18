<?php

use App\Models\Company;
use App\Models\Departamento;
use App\Models\Provincia;

// Script simple para crear empresas de prueba

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 Verificando base de datos...\n";

// Verificar departamentos
$departamentos = Departamento::count();
echo "Departamentos encontrados: $departamentos\n";

$provincias = Provincia::count();
echo "Provincias encontradas: $provincias\n";

// Obtener el primer departamento y provincia para las pruebas
$departamento = Departamento::first();
$provincia = Provincia::first();

echo "Usando departamento: " . ($departamento ? $departamento->nombre : 'Ninguno') . "\n";
echo "Usando provincia: " . ($provincia ? $provincia->nombre : 'Ninguna') . "\n";

// Crear empresas de prueba
$empresas = [
    [
        'ruc' => '20123456789',
        'razon_social' => 'Empresa Tecnológica Power GYMA S.A.C.',
        'telefono_fijo' => '01-4567890',
        'departamento_id' => $departamento?->id,
        'provincia_id' => $provincia?->id,
        'direccion_calle' => 'Av. Javier Prado Este 123, San Isidro',
        'activo' => true,
    ],
    [
        'ruc' => '20987654321',
        'razon_social' => 'Comercializadora Los Andes E.I.R.L.',
        'telefono_fijo' => '054-123456',
        'departamento_id' => $departamento?->id,
        'provincia_id' => $provincia?->id,
        'direccion_calle' => 'Calle Santa Catalina 456, Cercado',
        'activo' => true,
    ],
    [
        'ruc' => '20555666777',
        'razon_social' => 'Constructora Lima Norte S.A.',
        'telefono_fijo' => '01-2345678',
        'departamento_id' => $departamento?->id,
        'provincia_id' => $provincia?->id,
        'direccion_calle' => 'Av. Túpac Amaru 789, Los Olivos',
        'activo' => true,
    ],
];

echo "\n📝 Creando empresas de prueba...\n";

foreach ($empresas as $empresaData) {
    try {
        $empresa = Company::updateOrCreate(
            ['ruc' => $empresaData['ruc']],
            $empresaData
        );
        echo "✅ Creada/Actualizada: {$empresa->razon_social} (RUC: {$empresa->ruc})\n";
    } catch (Exception $e) {
        echo "❌ Error creando empresa {$empresaData['ruc']}: " . $e->getMessage() . "\n";
    }
}

$totalEmpresas = Company::count();
echo "\n🏢 Total de empresas en base de datos: $totalEmpresas\n";

echo "\n📋 RUCs de prueba para autocompletado:\n";
foreach ($empresas as $empresa) {
    echo "   • {$empresa['ruc']} - {$empresa['razon_social']}\n";
}

echo "\n✅ Script completado. Puedes probar el autocompletado con estos RUCs.\n";