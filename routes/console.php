<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\RiskCalculationService;
use App\Models\DemoRequest;
use App\Models\Departamento;
use App\Models\Provincia;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Comando para actualizar el sistema de riesgo
Artisan::command('risk:update {--force} {--clean} {--excel=}', function () {
    $this->info('🔄 Iniciando actualización del sistema de riesgo...');
    
    try {
        $riskService = app(RiskCalculationService::class);
        
        // Limpiar datos antiguos si se especifica
        if ($this->option('clean')) {
            $this->info('🧹 Limpiando datos antiguos...');
            $riskService->cleanOldData();
            $this->info('✅ Datos antiguos limpiados');
        }

        // Actualizar por datos de Excel si se especifica
        if ($this->option('excel')) {
            $excelId = $this->option('excel');
            $this->info("📊 Actualizando con datos de Excel ID: $excelId");
            $riskService->updateRiskByExcelData($excelId);
            $this->info('✅ Sistema actualizado con datos de Excel');
        } else {
            // Actualizar por tiempo
            $this->info('⏰ Actualizando sistema basado en tiempo actual...');
            $evaluation = $riskService->updateRiskByTime();
            
            $this->info('✅ Sistema actualizado exitosamente');
            $this->table(
                ['Campo', 'Valor'],
                [
                    ['Fecha', $evaluation->evaluation_date->format('d/m/Y')],
                    ['Nivel de Riesgo', $evaluation->risk_level],
                    ['Horario Pico', $evaluation->start_time . ' - ' . $evaluation->end_time],
                    ['Consumo Total', number_format($evaluation->total_consumption, 2) . ' kWh'],
                    ['Demanda Máxima', number_format($evaluation->max_demand, 2) . ' kW'],
                    ['Factor de Potencia', number_format($evaluation->power_factor, 3)],
                    ['Costo Total', 'S/ ' . number_format($evaluation->total_cost, 2)],
                    ['Eficiencia', $evaluation->efficiency_percentage . '%']
                ]
            );
        }

        $this->info('📈 Datos del dashboard actualizados en caché');
        $this->info('🎉 Proceso completado exitosamente');
        
    } catch (\Exception $e) {
        $this->error('❌ Error al actualizar el sistema de riesgo: ' . $e->getMessage());
        return 1;
    }

    return 0;
})->purpose('Actualizar el sistema de riesgo automáticamente');

// Comando para probar el sistema de solicitudes de demo
Artisan::command('test:demo', function () {
    $this->info('🔄 Creando solicitud de demo de prueba...');
    
    try {
        // Obtener datos de ubicación
        $departamento = Departamento::first();
        $provincia = $departamento ? Provincia::where('departamento_id', $departamento->id)->first() : null;
        
        $this->info("📍 Departamento: " . ($departamento ? $departamento->nombre : 'No encontrado'));
        $this->info("📍 Provincia: " . ($provincia ? $provincia->nombre : 'No encontrada'));
        
        // Crear solicitud de demo
        $demo = DemoRequest::create([
            'nombre' => 'Juan Pérez García',
            'email' => 'juan.perez.' . time() . '@empresa-test.com',
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
            'comentarios' => 'Estamos interesados en implementar un sistema de gestión energética.',
            'necesidades_especificas' => 'Necesitamos monitorear el consumo de energía en tiempo real.',
            'acepta_terminos' => true,
            'acepta_marketing' => true,
            'origen_solicitud' => 'web',
        ]);
        
        $this->info("\n✅ Solicitud de demo creada exitosamente:");
        $this->table(
            ['Campo', 'Valor'],
            [
                ['ID', $demo->id],
                ['Nombre', $demo->nombre],
                ['Email', $demo->email],
                ['Empresa', $demo->empresa],
                ['Estado', $demo->estado_label],
                ['Tipo Demo', $demo->tipo_demo_label],
                ['Fecha', $demo->created_at->format('d/m/Y H:i')]
            ]
        );
        
        // Mostrar estadísticas
        $stats = [
            'Total' => DemoRequest::count(),
            'Pendientes' => DemoRequest::where('estado', 'pendiente')->count(),
            'Contactados' => DemoRequest::where('estado', 'contactado')->count(),
            'Completados' => DemoRequest::where('estado', 'completado')->count(),
            'Recientes' => DemoRequest::recientes()->count(),
        ];
        
        $this->info("\n📊 Estadísticas de solicitudes:");
        $this->table(['Tipo', 'Cantidad'], collect($stats)->map(fn($value, $key) => [$key, $value])->toArray());
        
        // Probar métodos del modelo
        $this->info("\n🔧 Probando métodos del modelo:");
        $this->table(
            ['Método', 'Resultado'],
            [
                ['¿Es pendiente?', $demo->isPendiente() ? 'Sí' : 'No'],
                ['¿Es completada?', $demo->isCompletada() ? 'Sí' : 'No'],
                ['Email único (nuevo)', DemoRequest::isEmailUnique('nuevo@email.com') ? 'Sí' : 'No'],
                ['Email existente único', DemoRequest::isEmailUnique($demo->email) ? 'Sí' : 'No']
            ]
        );
        
        // Probar actualización de estado
        $this->info("\n🔄 Probando actualización de estado:");
        $demo->marcarComoContactado('Cliente muy interesado en el sistema');
        $this->info("Estado actualizado a: {$demo->estado_label}");
        $this->info("Fecha contacto: {$demo->fecha_contacto->format('d/m/Y H:i')}");
        
        $this->info("\n🎉 Prueba completada exitosamente");
        
    } catch (\Exception $e) {
        $this->error('❌ Error en la prueba: ' . $e->getMessage());
        $this->error('Stack trace: ' . $e->getTraceAsString());
        return 1;
    }
    
    return 0;
})->purpose('Crear y probar una solicitud de demo');
