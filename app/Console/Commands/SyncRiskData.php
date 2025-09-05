<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RiskEvaluation;
use App\Models\MonthlyRiskData;
use Carbon\Carbon;

class SyncRiskData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'risk:sync-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronizar datos de RiskEvaluation con MonthlyRiskData más reciente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sincronizando datos de riesgo...');
        
        // Corregir el día de hoy específicamente
        $today = now();
        $this->info("Procesando día actual: {$today->format('Y-m-d')}");
        
        // Buscar dato mensual para hoy
        $monthlyToday = MonthlyRiskData::where('year', $today->year)
                                     ->where('month', $today->month)
                                     ->where('day', $today->day)
                                     ->first();
        
        if ($monthlyToday) {
            $this->line("Dato mensual encontrado: {$monthlyToday->risk_level}");
            
            // Buscar evaluación existente para hoy
            $evalToday = RiskEvaluation::whereDate('evaluation_date', $today)->first();
            
            if ($evalToday) {
                $oldLevel = $evalToday->risk_level;
                $evalToday->update(['risk_level' => $monthlyToday->risk_level]);
                $this->line("✅ Evaluación actualizada: {$oldLevel} → {$monthlyToday->risk_level}");
            } else {
                $this->line("❌ No hay evaluación para hoy");
            }
        } else {
            $this->line("❌ No hay dato mensual para hoy");
        }
        
        // Ahora corregir según tu CSV específico
        $this->info("\nAplicando correcciones según tu CSV:");
        
        // Actualizar evaluación del 29-ago (debe ser Alto según CSV)
        $date29 = Carbon::create(2025, 8, 29);
        $eval29 = RiskEvaluation::whereDate('evaluation_date', $date29)->first();
        
        if ($eval29) {
            if ($eval29->risk_level !== 'Alto') {
                $eval29->update([
                    'risk_level' => 'Alto',
                    'start_time' => '20:00',
                    'end_time' => '21:00'
                ]);
                $this->line("✅ 29-ago corregido a: Alto (20:00-21:00)");
            } else {
                $this->line("✅ 29-ago ya está correcto: Alto");
            }
        } else {
            // Crear evaluación para el 29-ago
            RiskEvaluation::create([
                'evaluation_date' => $date29,
                'risk_level' => 'Alto',
                'start_time' => '20:00',
                'end_time' => '21:00'
            ]);
            $this->line("✅ 29-ago creado: Alto (20:00-21:00)");
        }
        
        // Verificar el resultado
        $this->info("\nVerificación final:");
        $todayEval = RiskEvaluation::whereDate('evaluation_date', $today)->first();
        if ($todayEval) {
            $this->line("Hoy ({$today->format('Y-m-d')}): {$todayEval->risk_level}");
        }
        
        $eval29Final = RiskEvaluation::whereDate('evaluation_date', $date29)->first();
        if ($eval29Final) {
            $this->line("29-ago: {$eval29Final->risk_level} ({$eval29Final->start_time}-{$eval29Final->end_time})");
        }
        
        $this->info("\n✅ Sincronización completada!");
        
        return 0;
    }
}
