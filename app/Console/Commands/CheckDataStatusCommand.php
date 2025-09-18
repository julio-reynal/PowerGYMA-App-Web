<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RiskEvaluation;
use App\Models\MonthlyRiskData;
use App\Models\ExcelUpload;
use Carbon\Carbon;

class CheckDataStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar el estado actual del sistema de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== ESTADO DEL SISTEMA DE DATOS ===');
        $this->line('');
        
        // Verificar datos de RiskEvaluation
        $this->checkRiskEvaluations();
        
        // Verificar datos de MonthlyRiskData
        $this->checkMonthlyRiskData();
        
        // Verificar datos de ExcelUpload
        $this->checkExcelUploads();
        
        // Verificar datos del mes actual y anterior
        $this->checkCurrentAndPreviousMonth();
        
        return 0;
    }
    
    /**
     * Verificar datos de RiskEvaluation
     */
    private function checkRiskEvaluations()
    {
        $this->info('1. Datos de RiskEvaluation:');
        $total = RiskEvaluation::count();
        $this->line("   Total de registros: {$total}");
        
        if ($total > 0) {
            $latest = RiskEvaluation::orderBy('evaluation_date', 'desc')->first();
            $this->line("   Último registro: {$latest->evaluation_date} (Nivel: {$latest->risk_level})");
            
            // Contar por mes
            $this->line('   Registros por mes:');
            $monthlyCounts = RiskEvaluation::selectRaw('YEAR(evaluation_date) as year, MONTH(evaluation_date) as month, COUNT(*) as count')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(5)
                ->get();
                
            foreach ($monthlyCounts as $count) {
                $monthName = Carbon::create($count->year, $count->month, 1)->locale('es')->monthName;
                $this->line("     {$monthName} {$count->year}: {$count->count} registros");
            }
        } else {
            $this->line('   No hay registros disponibles.');
        }
        
        $this->line('');
    }
    
    /**
     * Verificar datos de MonthlyRiskData
     */
    private function checkMonthlyRiskData()
    {
        $this->info('2. Datos de MonthlyRiskData:');
        $total = MonthlyRiskData::count();
        $this->line("   Total de registros: {$total}");
        
        if ($total > 0) {
            // Contar por mes
            $this->line('   Registros por mes:');
            $monthlyCounts = MonthlyRiskData::selectRaw('year, month, COUNT(*) as count')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(5)
                ->get();
                
            foreach ($monthlyCounts as $count) {
                $monthName = Carbon::create($count->year, $count->month, 1)->locale('es')->monthName;
                $this->line("     {$monthName} {$count->year}: {$count->count} registros");
            }
        } else {
            $this->line('   No hay registros disponibles.');
        }
        
        $this->line('');
    }
    
    /**
     * Verificar datos de ExcelUpload
     */
    private function checkExcelUploads()
    {
        $this->info('3. Datos de ExcelUpload:');
        $total = ExcelUpload::count();
        $this->line("   Total de archivos subidos: {$total}");
        
        if ($total > 0) {
            $latest = ExcelUpload::orderBy('created_at', 'desc')->first();
            $this->line("   Último archivo subido: {$latest->created_at->format('d/m/Y H:i')} ({$latest->original_filename})");
        } else {
            $this->line('   No hay archivos subidos.');
        }
        
        $this->line('');
    }
    
    /**
     * Verificar datos del mes actual y anterior
     */
    private function checkCurrentAndPreviousMonth()
    {
        $this->info('4. Datos por período:');
        
        $currentMonth = now();
        $previousMonth = now()->subMonth();
        
        $this->line('   Mes actual (' . $currentMonth->locale('es')->monthName . ' ' . $currentMonth->year . '):');
        
        // RiskEvaluation del mes actual
        $currentRiskEval = RiskEvaluation::whereYear('evaluation_date', $currentMonth->year)
            ->whereMonth('evaluation_date', $currentMonth->month)
            ->count();
        $this->line("     RiskEvaluation: {$currentRiskEval} registros");
        
        // MonthlyRiskData del mes actual
        $currentMonthly = MonthlyRiskData::where('year', $currentMonth->year)
            ->where('month', $currentMonth->month)
            ->count();
        $this->line("     MonthlyRiskData: {$currentMonthly} registros");
        
        $this->line('   Mes anterior (' . $previousMonth->locale('es')->monthName . ' ' . $previousMonth->year . '):');
        
        // RiskEvaluation del mes anterior
        $previousRiskEval = RiskEvaluation::whereYear('evaluation_date', $previousMonth->year)
            ->whereMonth('evaluation_date', $previousMonth->month)
            ->count();
        $this->line("     RiskEvaluation: {$previousRiskEval} registros");
        
        // MonthlyRiskData del mes anterior
        $previousMonthly = MonthlyRiskData::where('year', $previousMonth->year)
            ->where('month', $previousMonth->month)
            ->count();
        $this->line("     MonthlyRiskData: {$previousMonthly} registros");
        
        $this->line('');
        $this->info('=== FIN DEL ESTADO DEL SISTEMA ===');
    }
}
