<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RiskEvaluation;
use App\Models\MonthlyRiskData;
use Carbon\Carbon;

class DebugLastMonthDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:last-month-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Depurar los datos del mes pasado que encuentra el sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== DEPURACIÓN DE DATOS DEL MES PASADO ===');
        $this->line('');
        
        // Fecha actual y mes pasado
        $currentDate = now();
        $lastMonth = $currentDate->subMonth();
        $year = $lastMonth->year;
        $month = $lastMonth->month;
        
        $this->line("Fecha actual: " . now()->format('Y-m-d H:i:s'));
        $this->line("Mes pasado: " . $lastMonth->format('Y-m') . " (" . $lastMonth->locale('es')->monthName . " " . $year . ")");
        $this->line('');
        
        // Buscar datos en RiskEvaluation
        $this->info('1. Buscando en RiskEvaluation:');
        $evalData = RiskEvaluation::whereYear('evaluation_date', $year)
            ->whereMonth('evaluation_date', $month)
            ->orderBy('evaluation_date', 'desc')
            ->first();
            
        if ($evalData) {
            $this->line("   Encontrado: " . $evalData->evaluation_date . " - Nivel: " . $evalData->risk_level);
        } else {
            $this->line("   No se encontraron registros en RiskEvaluation para " . $lastMonth->format('Y-m'));
        }
        
        $this->line('');
        
        // Buscar datos en MonthlyRiskData
        $this->info('2. Buscando en MonthlyRiskData:');
        $monthlyData = MonthlyRiskData::where('year', $year)
            ->where('month', $month)
            ->whereNotNull('risk_level')
            ->orderBy('day', 'desc')
            ->first();
            
        if ($monthlyData) {
            $this->line("   Encontrado: " . $monthlyData->year . "-" . $monthlyData->month . "-" . $monthlyData->day . " - Nivel: " . $monthlyData->risk_level);
        } else {
            $this->line("   No se encontraron registros en MonthlyRiskData para " . $lastMonth->format('Y-m'));
        }
        
        $this->line('');
        
        // Contar registros totales
        $this->info('3. Conteo de registros:');
        $evalCount = RiskEvaluation::whereYear('evaluation_date', $year)
            ->whereMonth('evaluation_date', $month)
            ->count();
            
        $monthlyCount = MonthlyRiskData::where('year', $year)
            ->where('month', $month)
            ->whereNotNull('risk_level')
            ->count();
            
        $this->line("   RiskEvaluation: " . $evalCount . " registros");
        $this->line("   MonthlyRiskData: " . $monthlyCount . " registros");
        
        $this->line('');
        $this->info('=== FIN DE LA DEPURACIÓN ===');
        
        return 0;
    }
}
