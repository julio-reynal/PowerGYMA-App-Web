<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RiskCalculationService;
use Carbon\Carbon;

class UpdateRiskSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'risk:update 
                            {--force : Forzar actualización incluso si ya existe para hoy}
                            {--clean : Limpiar datos antiguos}
                            {--excel= : ID del Excel a procesar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar el sistema de riesgo automáticamente basado en tiempo y datos de Excel';

    protected $riskService;

    public function __construct(RiskCalculationService $riskService)
    {
        parent::__construct();
        $this->riskService = $riskService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Iniciando actualización del sistema de riesgo...');
        
        try {
            // Limpiar datos antiguos si se especifica
            if ($this->option('clean')) {
                $this->info('🧹 Limpiando datos antiguos...');
                $this->riskService->cleanOldData();
                $this->info('✅ Datos antiguos limpiados');
            }

            // Actualizar por datos de Excel si se especifica
            if ($this->option('excel')) {
                $excelId = $this->option('excel');
                $this->info("📊 Actualizando con datos de Excel ID: $excelId");
                $this->riskService->updateRiskByExcelData($excelId);
                $this->info('✅ Sistema actualizado con datos de Excel');
            } else {
                // Actualizar por tiempo
                $this->info('⏰ Actualizando sistema basado en tiempo actual...');
                $evaluation = $this->riskService->updateRiskByTime();
                
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
            $this->error('📍 Línea: ' . $e->getLine());
            $this->error('📁 Archivo: ' . $e->getFile());
            return 1;
        }

        return 0;
    }
}