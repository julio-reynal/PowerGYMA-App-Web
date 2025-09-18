<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExcelUpload;
use App\Models\RiskEvaluation;
use App\Models\MonthlyRiskData;
use Illuminate\Support\Facades\Storage;

class CleanExcelDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'excel:clean {--all : Eliminar todos los datos relacionados con Excel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar datos de archivos Excel subidos anteriormente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('all')) {
            $this->info('Eliminando todos los datos relacionados con Excel...');
            
            // Eliminar registros de ExcelUpload
            $this->info('Eliminando registros de ExcelUpload...');
            ExcelUpload::truncate();
            
            // Eliminar registros de RiskEvaluation
            $this->info('Eliminando registros de RiskEvaluation...');
            RiskEvaluation::truncate();
            
            // Eliminar registros de MonthlyRiskData
            $this->info('Eliminando registros de MonthlyRiskData...');
            MonthlyRiskData::truncate();
            
            // Eliminar archivos físicos
            $this->info('Eliminando archivos físicos de Excel...');
            $this->cleanExcelFiles();
            
            // Limpiar caché
            $this->info('Limpiando caché...');
            $this->call('cache:clear');
            
            $this->info('¡Todos los datos de Excel han sido eliminados exitosamente!');
        } else {
            $this->info('Eliminando datos de archivos Excel subidos...');
            
            // Eliminar solo los registros de ExcelUpload
            $count = ExcelUpload::count();
            ExcelUpload::truncate();
            $this->info("Se eliminaron {$count} registros de archivos Excel subidos.");
            
            // Eliminar archivos físicos
            $this->cleanExcelFiles();
            
            $this->info('¡Datos de archivos Excel subidos han sido eliminados exitosamente!');
        }
        
        return 0;
    }
    
    /**
     * Eliminar archivos físicos de Excel
     */
    private function cleanExcelFiles()
    {
        $directory = 'excel_uploads';
        
        if (Storage::exists($directory)) {
            $files = Storage::files($directory);
            $count = count($files);
            
            foreach ($files as $file) {
                Storage::delete($file);
            }
            
            // También eliminar el directorio si está vacío
            if (Storage::directories($directory) === []) {
                Storage::deleteDirectory($directory);
            }
            
            $this->info("Se eliminaron {$count} archivos de Excel.");
        } else {
            $this->info('No se encontró el directorio de archivos Excel.');
        }
    }
}
