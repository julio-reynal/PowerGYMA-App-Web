<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExcelUpload;
use App\Models\MonthlyRiskData;
use App\Services\RiskCalculationService;

class UpdateMonthProgress extends Command
{
    protected $signature = 'month:update-progress 
                            {--excel= : ID del Excel específico a usar} 
                            {--month= : Mes a actualizar (por defecto mes actual)}
                            {--year= : Año a actualizar (por defecto año actual)}
                            {--force : Forzar actualización incluso si ya está evaluado}';

    protected $description = 'Actualizar el progreso del mes basándose en datos de Excel';

    public function handle()
    {
        $this->info('🔄 Actualizando progreso del mes...');

        $year = $this->option('year') ?? now()->year;
        $month = $this->option('month') ?? now()->month;
        $excelId = $this->option('excel');
        $force = $this->option('force');

        $this->info("📅 Procesando: {$month}/{$year}");

        // Obtener Excel a usar
        if ($excelId) {
            $excel = ExcelUpload::find($excelId);
            if (!$excel) {
                $this->error("❌ Excel ID {$excelId} no encontrado");
                return 1;
            }
        } else {
            $excel = ExcelUpload::orderBy('created_at', 'desc')->first();
            if (!$excel) {
                $this->error("❌ No hay archivos Excel subidos");
                return 1;
            }
        }

        $this->info("📄 Usando Excel: {$excel->original_name} (ID: {$excel->id})");

        // Verificar si el Excel tiene datos procesados
        if (!$excel->processed_data || !isset($excel->processed_data['monthly_data'])) {
            $this->warn("⚠️  El Excel no tiene datos mensuales procesados. Reprocesando...");
            
            try {
                $excelProcessor = app(\App\Services\ExcelProcessorService::class);
                $result = $excelProcessor->processExcelFile($excel->file_path, $excel->id, $year);
                
                if (!$result['success']) {
                    $this->error("❌ Error al reprocesar Excel: " . $result['message']);
                    return 1;
                }
                
                $excel->refresh();
                $this->info("✅ Excel reprocesado exitosamente");
            } catch (\Exception $e) {
                $this->error("❌ Error al reprocesar Excel: " . $e->getMessage());
                return 1;
            }
        }

        $monthlyData = $excel->processed_data['monthly_data'] ?? [];
        $this->info("📊 Registros mensuales encontrados: " . count($monthlyData));

        $updated = 0;
        $created = 0;
        $skipped = 0;

        foreach ($monthlyData as $data) {
            $date = \Carbon\Carbon::parse($data['fecha']);
            
            // Solo procesar el mes/año especificado
            if ($date->year != $year || $date->month != $month) {
                continue;
            }

            $riskLevel = trim($data['nivel_riesgo'] ?? '');
            
            // Saltear días sin nivel de riesgo o null
            if (empty($riskLevel) || strtolower($riskLevel) === 'null') {
                $skipped++;
                continue;
            }

            $existing = MonthlyRiskData::where('year', $date->year)
                ->where('month', $date->month)
                ->where('day', $date->day)
                ->first();

            if ($existing) {
                // Solo actualizar si está pendiente o si se fuerza
                if ($existing->status === 'pendiente' || empty($existing->risk_level) || $force) {
                    $existing->update([
                        'risk_level' => $riskLevel,
                        'status' => 'evaluado',
                        'updated_at' => now()
                    ]);
                    $this->line("✅ Día {$date->day}: {$riskLevel}");
                    $updated++;
                } else {
                    $this->line("ℹ️  Día {$date->day}: ya evaluado ({$existing->risk_level})");
                }
            } else {
                MonthlyRiskData::create([
                    'year' => $date->year,
                    'month' => $date->month,
                    'day' => $date->day,
                    'risk_level' => $riskLevel,
                    'status' => 'evaluado'
                ]);
                $this->line("🆕 Día {$date->day}: {$riskLevel}");
                $created++;
            }
        }

        // Actualizar sistema de riesgo
        $this->info("\n🔄 Actualizando sistema de riesgo...");
        $riskService = app(RiskCalculationService::class);
        $riskService->updateRiskByExcelData($excel->id);

        // Mostrar progreso final
        $monthlyComplete = MonthlyRiskData::where('year', $year)
            ->where('month', $month)
            ->where('status', 'evaluado')
            ->count();

        $monthlyTotal = MonthlyRiskData::where('year', $year)
            ->where('month', $month)
            ->count();

        $progressPercent = $monthlyTotal > 0 ? round(($monthlyComplete / $monthlyTotal) * 100) : 0;

        $this->info("\n=== RESULTADO ===");
        $this->table(['Concepto', 'Valor'], [
            ['Registros actualizados', $updated],
            ['Registros creados', $created],
            ['Registros saltados (null)', $skipped],
            ['Días evaluados', $monthlyComplete],
            ['Total días del mes', $monthlyTotal],
            ['Progreso del mes', "{$progressPercent}%"]
        ]);

        $this->info("✅ Proceso completado. Actualiza el dashboard para ver los cambios.");

        return 0;
    }
}