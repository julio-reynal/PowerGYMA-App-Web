<?php
// Comandos para ejecutar en artisan tinker

// 1. Verificar que la tabla existe
echo "Schema::hasTable('demo_requests')\n";

// 2. Crear una solicitud de demo de prueba
echo "\$departamento = App\\Models\\Departamento::first();\n";
echo "\$provincia = \$departamento ? App\\Models\\Provincia::where('departamento_id', \$departamento->id)->first() : null;\n";

echo "
\$demo = App\\Models\\DemoRequest::create([
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
    'departamento_id' => \$departamento?->id,
    'provincia_id' => \$provincia?->id,
    'tipo_demo' => 'evaluacion',
    'comentarios' => 'Estamos interesados en implementar un sistema de gestión energética.',
    'necesidades_especificas' => 'Necesitamos monitorear el consumo de energía en tiempo real.',
    'acepta_terminos' => true,
    'acepta_marketing' => true,
    'origen_solicitud' => 'web',
]);
";

echo "\n// Ver la solicitud creada\n";
echo "\$demo->toArray()\n";

echo "\n// Verificar métodos del modelo\n";
echo "\$demo->estado_label\n";
echo "\$demo->tipo_demo_label\n";
echo "\$demo->isPendiente()\n";

echo "\n// Actualizar estado\n";
echo "\$demo->marcarComoContactado('Cliente muy interesado');\n";
echo "\$demo->estado_label\n";

echo "\n// Ver estadísticas\n";
echo "App\\Models\\DemoRequest::count()\n";
echo "App\\Models\\DemoRequest::where('estado', 'pendiente')->count()\n";
echo "App\\Models\\DemoRequest::recientes()->count()\n";