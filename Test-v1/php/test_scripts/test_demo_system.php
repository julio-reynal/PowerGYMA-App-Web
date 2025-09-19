<?php
// Script de prueba para verificar el sistema de solicitudes de demo

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\DemoRequest;
use App\Models\Departamento;
use App\Models\Provincia;

// Crear una solicitud de demo de prueba
try {
    // Verificar que existan departamentos y provincias
    $departamento = Departamento::first();
    $provincia = $departamento ? Provincia::where('departamento_id', $departamento->id)->first() : null;

    $demoRequest = DemoRequest::create([
        'nombre' => 'Juan Pérez García',
        'email' => 'juan.perez@empresa-test.com',
        'telefono_celular' => '999888777',
        'telefono' => '014567890',
        'tipo_documento' => 'DNI',
        'numero_documento' => '12345678',
        'empresa' => 'Empresa Test S.A.C.',
        'ruc_empresa' => '20123456789',
        'giro_empresa' => 'Manufactura y Distribución',
        'cargo_puesto' => 'Gerente de Operaciones',
        'direccion' => 'Av. Prueba 123, Distrito Test',
        'ciudad' => 'Lima',
        'departamento_id' => $departamento?->id,
        'provincia_id' => $provincia?->id,
        'tipo_demo' => 'evaluacion',
        'comentarios' => 'Estamos interesados en implementar un sistema de gestión energética para reducir costos operativos.',
        'necesidades_especificas' => 'Necesitamos monitorear el consumo de energía en tiempo real y generar reportes automáticos.',
        'acepta_terminos' => true,
        'acepta_marketing' => true,
        'origen_solicitud' => 'web',
    ]);

    echo "✅ Solicitud de demo creada exitosamente:\n";
    echo "ID: {$demoRequest->id}\n";
    echo "Nombre: {$demoRequest->nombre}\n";
    echo "Email: {$demoRequest->email}\n";
    echo "Empresa: {$demoRequest->empresa}\n";
    echo "Estado: {$demoRequest->estado_label}\n";
    echo "Tipo Demo: {$demoRequest->tipo_demo_label}\n";
    echo "Fecha: {$demoRequest->created_at->format('d/m/Y H:i')}\n\n";

    // Mostrar estadísticas
    $stats = [
        'total' => DemoRequest::count(),
        'pendientes' => DemoRequest::where('estado', 'pendiente')->count(),
        'contactados' => DemoRequest::where('estado', 'contactado')->count(),
        'completados' => DemoRequest::where('estado', 'completado')->count(),
        'recientes' => DemoRequest::recientes()->count(),
    ];

    echo "📊 Estadísticas de solicitudes:\n";
    foreach ($stats as $key => $value) {
        echo ucfirst($key) . ": {$value}\n";
    }

    // Probar algunos métodos del modelo
    echo "\n🔧 Probando métodos del modelo:\n";
    echo "¿Es pendiente?: " . ($demoRequest->isPendiente() ? 'Sí' : 'No') . "\n";
    echo "¿Es completada?: " . ($demoRequest->isCompletada() ? 'Sí' : 'No') . "\n";
    echo "Email único: " . (DemoRequest::isEmailUnique('nuevo@email.com') ? 'Sí' : 'No') . "\n";
    echo "Email existente único: " . (DemoRequest::isEmailUnique($demoRequest->email) ? 'Sí' : 'No') . "\n";

    // Probar actualización de estado
    echo "\n🔄 Probando actualización de estado:\n";
    $demoRequest->marcarComoContactado('Cliente muy interesado en el sistema');
    echo "Estado actualizado a: {$demoRequest->estado_label}\n";
    echo "Fecha contacto: {$demoRequest->fecha_contacto->format('d/m/Y H:i')}\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}