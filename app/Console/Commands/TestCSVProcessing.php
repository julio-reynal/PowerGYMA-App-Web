<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ExcelProcessorService;

class TestCSVProcessing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:csv-processing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar el procesamiento del archivo CSV con valores null';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Probando el procesamiento de CSV con valores null...');
        
        $testFile = base_path('test_upload_fixed.csv');
        
        if (!file_exists($testFile)) {
            $this->error("Archivo no encontrado: {$testFile}");
            return 1;
        }
        
        try {
            $processor = new ExcelProcessorService();
            $result = $processor->processExcelFile($testFile, 1);
            
            $this->info('Procesamiento exitoso!');
            $this->line('Resultados:');
            $this->line('- Evaluaciones diarias: ' . ($result['daily_evaluations'] ?? 0));
            $this->line('- Datos mensuales: ' . ($result['monthly_data'] ?? 0));
            
            if (isset($result['summary'])) {
                $this->line('Resumen:');
                foreach ($result['summary'] as $key => $value) {
                    if (is_array($value)) {
                        $this->line("  {$key}: " . json_encode($value));
                    } else {
                        $this->line("  {$key}: {$value}");
                    }
                }
            }
            
        } catch (\Exception $e) {
            $this->error('Error durante el procesamiento:');
            $this->error($e->getMessage());
            $this->line('Trace:');
            $this->line($e->getTraceAsString());
            return 1;
        }
        
        return 0;
    }
}
