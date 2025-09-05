<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RiskEvaluation;
use App\Models\MonthlyRiskData;
use Carbon\Carbon;

class CheckDashboardData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:dashboard-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar datos que se muestran en el dashboard';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== VERIFICACIÓN DE DATOS DEL DASHBOARD ===');
        
        $today = now();
        $this->info("Fecha actual: {$today->format('Y-m-d')}");
        
        // 1. Verificar evaluación del día actual
        $this->info("\n1. EVALUACIÓN DEL DÍA ACTUAL:");
        $todayEval = RiskEvaluation::whereDate('evaluation_date', $today)->first();
        
        if ($todayEval) {
            $this->line("✅ Encontrada evaluación para hoy:");
            $this->line("   Nivel: {$todayEval->risk_level}");
            $this->line("   Fecha: {$todayEval->evaluation_date->format('Y-m-d')}");
            $this->line("   Horario: {$todayEval->start_time} - {$todayEval->end_time}");
        } else {
            $this->line("❌ NO hay evaluación para hoy");
            
            // Buscar última evaluación
            $lastEval = RiskEvaluation::orderBy('evaluation_date', 'desc')->first();
            if ($lastEval) {
                $this->line("   Última evaluación encontrada:");
                $this->line("   Nivel: {$lastEval->risk_level}");
                $this->line("   Fecha: {$lastEval->evaluation_date->format('Y-m-d')}");
            }
        }
        
        // 2. Verificar último dato mensual
        $this->info("\n2. ÚLTIMO DATO MENSUAL:");
        $lastMonthly = MonthlyRiskData::orderBy('year', 'desc')
                                     ->orderBy('month', 'desc')
                                     ->orderBy('day', 'desc')
                                     ->first();
        
        if ($lastMonthly) {
            $this->line("✅ Último dato mensual:");
            $this->line("   Nivel: {$lastMonthly->risk_level}");
            $this->line("   Fecha: {$lastMonthly->year}-{$lastMonthly->month}-{$lastMonthly->day}");
            $this->line("   Status: {$lastMonthly->status}");
        } else {
            $this->line("❌ NO hay datos mensuales");
        }
        
        // 3. Verificar datos de agosto 2025
        $this->info("\n3. DATOS DE AGOSTO 2025:");
        $august = MonthlyRiskData::where('year', 2025)
                                ->where('month', 8)
                                ->orderBy('day')
                                ->get();
        
        $this->line("Total de días en agosto: {$august->count()}");
        
        if ($august->count() > 0) {
            $this->line("Primeros 10 días:");
            foreach ($august->take(10) as $day) {
                $this->line("   Día {$day->day}: {$day->risk_level} ({$day->status})");
            }
            
            $this->line("Últimos 5 días:");
            foreach ($august->reverse()->take(5) as $day) {
                $this->line("   Día {$day->day}: {$day->risk_level} ({$day->status})");
            }
        }
        
        // 4. Verificar qué debería mostrar el dashboard
        $this->info("\n4. LO QUE DEBERÍA MOSTRAR EL DASHBOARD:");
        
        // Lógica del dashboard (copiada del controlador)
        $todayEvalForDashboard = RiskEvaluation::today() ?? RiskEvaluation::orderBy('evaluation_date','desc')->first();
        $riskLevel = $todayEvalForDashboard?->risk_level ?? null;
        
        if (!$riskLevel) {
            $latestMonth = MonthlyRiskData::orderBy('year','desc')->orderBy('month','desc')->orderBy('day','desc')->first();
            $riskLevel = $latestMonth?->risk_level ?? 'No procede';
        }
        
        $this->line("Nivel de riesgo que debería mostrar: {$riskLevel}");
        
        // 5. Verificar discrepancias
        $this->info("\n5. DISCREPANCIAS ENCONTRADAS:");
        
        $monthlyToday = MonthlyRiskData::where('year', $today->year)
                                     ->where('month', $today->month)
                                     ->where('day', $today->day)
                                     ->first();
        
        if ($todayEval && $monthlyToday) {
            $this->line("❗ CONFLICTO DE DATOS PARA HOY:");
            $this->line("   RiskEvaluation (hoy): {$todayEval->risk_level}");
            $this->line("   MonthlyRiskData (hoy): {$monthlyToday->risk_level}");
            
            if ($todayEval->risk_level !== $monthlyToday->risk_level) {
                $this->line("❌ Los datos NO coinciden");
                $this->line("✅ SOLUCIÓN: Sincronizar datos según el CSV más reciente");
            }
        }
        
        return 0;
    }
}
