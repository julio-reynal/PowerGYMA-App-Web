<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DemoExcelProcessorService;
use App\Services\DemoDashboardSnapshotService;
use Illuminate\Support\Facades\Storage;

class TestDemoExcelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:test-excel {--file=} {--year=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar el procesamiento de Excel para demo con conversión de fechas';

    protected $demoProcessor;
    protected $demoSnapshotService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DemoExcelProcessorService $demoProcessor, DemoDashboardSnapshotService $demoSnapshotService)
    {
        parent::__construct();
        $this->demoProcessor = $demoProcessor;
        $this->demoSnapshotService = $demoSnapshotService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🚀 Iniciando prueba del procesamiento de Excel para Demo...');
        $this->info('📅 Mes objetivo: ' . now()->subMonth()->locale('es')->isoFormat('MMMM YYYY'));
        $this->newLine();

        try {
            // Obtener archivo de prueba
            $fileName = $this->option('file') ?: 'plantilla_demo_riesgo_ejemplo.csv';
            $year = $this->option('year') ?: now()->year;
            
            // Buscar archivo en varias ubicaciones
            $possiblePaths = [
                resource_path('templates/' . $fileName),
                base_path($fileName),
                storage_path('app/' . $fileName)
            ];
            
            $filePath = null;
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $filePath = $path;
                    break;
                }
            }
            
            if (!$filePath) {
                // Crear archivo de prueba si no existe
                $this->warn('📄 Archivo no encontrado, creando archivo de prueba...');
                $filePath = $this->createTestFile();
            }
            
            $this->info('📁 Usando archivo: ' . $filePath);
            $this->info('📅 Año original de los datos: ' . $year);
            $this->newLine();

            // Procesar archivo con el servicio de demo
            $this->info('⚙️ Procesando archivo con conversión de fechas...');
            $result = $this->demoProcessor->processDemoFile($filePath, null, (int) $year);
            
            if ($result['success']) {
                $this->info('✅ ' . $result['message']);
                $this->newLine();
                
                // Mostrar resumen
                $summary = $result['summary'];
                $this->line('<info>📊 Resumen del procesamiento:</info>');
                $this->line('   • Evaluaciones diarias: ' . $summary['daily_evaluations']);
                $this->line('   • Datos mensuales: ' . $summary['monthly_data']);
                $this->line('   • Modo demo: ' . ($summary['demo_mode'] ? '✅ Activado' : '❌ Desactivado'));
                $this->line('   • Fechas convertidas: ' . ($summary['converted_to_previous_month'] ? '✅ Sí' : '❌ No'));
                $this->newLine();
                
                // Refrescar caché del demo
                $this->info('🔄 Refrescando caché del dashboard demo...');
                $snapshot = $this->demoSnapshotService->refreshCache();
                
                $this->info('✅ Caché actualizada exitosamente');
                $this->line('<info>📊 Información del demo:</info>');
                $this->line('   • Mes: ' . ($snapshot['demoInfo']['month_spanish'] ?? 'N/A'));
                $this->line('   • Datos simulados: ' . ($snapshot['demoInfo']['is_simulated'] ? 'Sí' : 'No'));
                $this->line('   • Cantidad de datos: ' . ($snapshot['demoInfo']['data_count'] ?? 0));
                $this->newLine();
                
                $this->info('🎯 Prueba completada exitosamente!');
                $this->line('<comment>💡 Puedes ver los resultados en el dashboard demo: /demo/dashboard</comment>');
                
            } else {
                $this->error('❌ Error en el procesamiento: ' . $result['message']);
                return 1;
            }
            
        } catch (\Exception $e) {
            $this->error('💥 Error durante la prueba: ' . $e->getMessage());
            $this->line('<comment>📍 Trace: ' . $e->getFile() . ':' . $e->getLine() . '</comment>');
            return 1;
        }
        
        return 0;
    }

    /**
     * Crear un archivo de prueba CSV
     */
    private function createTestFile()
    {
        $testContent = "FECHA,17-sept\nRIESGO,Alto\nHORA INICIO,09:00\nHORA FIN,17:00\n\n";
        
        // Generar datos para todo el mes
        for ($day = 1; $day <= 30; $day++) {
            $riskLevels = ['Bajo', 'Moderado', 'Alto'];
            $risk = $riskLevels[array_rand($riskLevels)];
            
            // Días de fin de semana como "No procede"
            if ($day % 7 == 0 || ($day + 1) % 7 == 0) {
                $risk = 'No procede';
            }
            
            $testContent .= "{$day}-sept,{$risk}\n";
        }
        
        $testPath = storage_path('app/test_demo_excel.csv');
        file_put_contents($testPath, $testContent);
        
        $this->line('<comment>📁 Archivo de prueba creado en: ' . $testPath . '</comment>');
        
        return $testPath;
    }
}