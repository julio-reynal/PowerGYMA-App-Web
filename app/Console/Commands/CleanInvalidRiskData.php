<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MonthlyRiskData;
use App\Models\RiskEvaluation;

class CleanInvalidRiskData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'risk:clean-invalid-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpia datos inválidos de riesgo y corrige valores null';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando limpieza de datos inválidos...');
        
        $validRiskLevels = ['Muy Bajo', 'Bajo', 'Moderado', 'Alto', 'Crítico', 'No procede'];
        
        // Limpiar MonthlyRiskData
        $this->info('Verificando MonthlyRiskData...');
        
        $invalidMonthly = MonthlyRiskData::whereNotIn('risk_level', $validRiskLevels)->get();
        $this->info("Encontrados {$invalidMonthly->count()} registros con niveles de riesgo inválidos en MonthlyRiskData");
        
        foreach ($invalidMonthly as $record) {
            $oldLevel = $record->risk_level;
            $record->update([
                'risk_level' => 'No procede',
                'status' => 'no_procede'
            ]);
            $this->line("Corregido: {$oldLevel} -> No procede para {$record->year}-{$record->month}-{$record->day}");
        }
        
        // Limpiar RiskEvaluation
        $this->info('Verificando RiskEvaluation...');
        
        $invalidEvaluations = RiskEvaluation::whereNotIn('risk_level', $validRiskLevels)->get();
        $this->info("Encontrados {$invalidEvaluations->count()} registros con niveles de riesgo inválidos en RiskEvaluation");
        
        foreach ($invalidEvaluations as $record) {
            $oldLevel = $record->risk_level;
            $record->update(['risk_level' => 'No procede']);
            $this->line("Corregido: {$oldLevel} -> No procede para {$record->evaluation_date->format('Y-m-d')}");
        }
        
        $this->info('Limpieza completada exitosamente!');
        
        return 0;
    }
}
