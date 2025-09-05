<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MonthlyRiskData;
use App\Models\RiskEvaluation;

class CheckRiskData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'risk:check-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar datos de riesgo en la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando datos de MonthlyRiskData...');
        
        $records = MonthlyRiskData::all();
        $this->info("Total de registros: {$records->count()}");
        
        $validLevels = ['Muy Bajo', 'Bajo', 'Moderado', 'Alto', 'Crítico', 'No procede'];
        
        foreach ($records as $record) {
            $risk = $record->risk_level;
            $valid = in_array($risk, $validLevels) ? '✓' : '✗';
            $this->line("{$valid} ID: {$record->id} - [{$risk}] - {$record->year}-{$record->month}-{$record->day}");
        }
        
        $this->info('Verificando datos de RiskEvaluation...');
        
        $evals = RiskEvaluation::all();
        $this->info("Total de evaluaciones: {$evals->count()}");
        
        foreach ($evals as $eval) {
            $risk = $eval->risk_level;
            $valid = in_array($risk, $validLevels) ? '✓' : '✗';
            $this->line("{$valid} ID: {$eval->id} - [{$risk}] - {$eval->evaluation_date->format('Y-m-d')}");
        }
        
        return 0;
    }
}
