<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RiskEvaluation;
use App\Models\MonthlyRiskData;
use Carbon\Carbon;

class ImportAugustDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:import-august {--real : Importar datos reales de ejemplo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar datos de ejemplo para agosto 2025';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('real')) {
            $this->importRealData();
        } else {
            $this->importSampleData();
        }
        
        // Refrescar la caché del dashboard demo
        $this->call('demo:refresh-dashboard');
        
        $this->info('¡Datos de agosto importados exitosamente!');
        
        return 0;
    }
    
    /**
     * Importar datos de ejemplo
     */
    private function importSampleData()
    {
        $this->info('Importando datos de ejemplo para agosto 2025...');
        
        // Eliminar datos existentes de agosto 2025
        $this->info('Eliminando datos existentes de agosto 2025...');
        RiskEvaluation::whereYear('evaluation_date', 2025)
            ->whereMonth('evaluation_date', 8)
            ->delete();
            
        MonthlyRiskData::where('year', 2025)
            ->where('month', 8)
            ->delete();
        
        // Crear datos de RiskEvaluation para agosto
        $riskLevels = ['Bajo', 'Moderado', 'Alto'];
        
        for ($i = 1; $i <= 15; $i++) {
            $date = Carbon::create(2025, 8, $i);
            
            // Solo días laborables (lunes a viernes)
            if ($date->isWeekday()) {
                RiskEvaluation::create([
                    'evaluation_date' => $date,
                    'risk_level' => $riskLevels[array_rand($riskLevels)],
                    'start_time' => sprintf('%02d:00', rand(8, 10)),
                    'end_time' => sprintf('%02d:00:00', rand(15, 18)),
                    'score' => rand(20, 90),
                    'recommendation' => 'Recomendación de ejemplo',
                    'hourly_data' => json_encode([
                        '08:00' => rand(20, 40),
                        '09:00' => rand(30, 50),
                        '10:00' => rand(40, 60),
                        '1:00' => rand(50, 70),
                        '12:00' => rand(60, 80),
                        '13:00' => rand(50, 70),
                        '14:00' => rand(40, 60),
                        '15:00' => rand(30, 50),
                        '16:00' => rand(20, 40),
                    ])
                ]);
            }
        }
        
        $this->line('Creados 15 registros de RiskEvaluation para agosto 2025');
        
        // Crear datos de MonthlyRiskData para agosto
        $daysInAugust = 31;
        
        for ($day = 1; $day <= $daysInAugust; $day++) {
            $date = Carbon::create(2025, 8, $day);
            
            // Solo días laborables (lunes a viernes)
            if ($date->isWeekday()) {
                MonthlyRiskData::create([
                    'year' => 2025,
                    'month' => 8,
                    'day' => $day,
                    'risk_level' => $riskLevels[array_rand($riskLevels)],
                    'status' => 'evaluado',
                    'total_consumption' => rand(1000, 5000),
                    'max_demand' => rand(100, 500),
                    'power_factor' => rand(80, 100) / 100,
                    'total_cost' => rand(500, 2000),
                    'efficiency_percentage' => rand(70, 95)
                ]);
            }
        }
        
        $this->line('Creados registros de MonthlyRiskData para agosto 2025');
    }
    
    /**
     * Importar datos reales de ejemplo (más realistas)
     */
    private function importRealData()
    {
        $this->info('Importando datos reales de ejemplo para agosto 2025...');
        
        // Eliminar datos existentes de agosto 2025
        $this->info('Eliminando datos existentes de agosto 2025...');
        RiskEvaluation::whereYear('evaluation_date', 2025)
            ->whereMonth('evaluation_date', 8)
            ->delete();
            
        MonthlyRiskData::where('year', 2025)
            ->where('month', 8)
            ->delete();
        
        // Crear datos de RiskEvaluation para agosto con patrones más realistas
        $riskData = [
            // Semana 1 - Riesgo medio
            ['date' => '2025-08-04', 'level' => 'Moderado', 'score' => 45],
            ['date' => '2025-08-05', 'level' => 'Moderado', 'score' => 50],
            ['date' => '2025-08-06', 'level' => 'Alto', 'score' => 70],
            ['date' => '2025-08-07', 'level' => 'Alto', 'score' => 75],
            ['date' => '2025-08-08', 'level' => 'Moderado', 'score' => 55],
            
            // Semana 2 - Riesgo alto
            ['date' => '2025-08-11', 'level' => 'Alto', 'score' => 80],
            ['date' => '2025-08-12', 'level' => 'Alto', 'score' => 85],
            ['date' => '2025-08-13', 'level' => 'Crítico', 'score' => 95],
            ['date' => '2025-08-14', 'level' => 'Alto', 'score' => 80],
            ['date' => '2025-08-15', 'level' => 'Moderado', 'score' => 60],
            
            // Semana 3 - Riesgo variable
            ['date' => '2025-08-18', 'level' => 'Moderado', 'score' => 50],
            ['date' => '2025-08-19', 'level' => 'Bajo', 'score' => 30],
            ['date' => '2025-08-20', 'level' => 'Moderado', 'score' => 55],
            ['date' => '2025-08-21', 'level' => 'Alto', 'score' => 75],
            ['date' => '2025-08-22', 'level' => 'Alto', 'score' => 80],
            
            // Semana 4 - Riesgo moderado
            ['date' => '2025-08-25', 'level' => 'Moderado', 'score' => 50],
            ['date' => '2025-08-26', 'level' => 'Moderado', 'score' => 45],
            ['date' => '2025-08-27', 'level' => 'Bajo', 'score' => 35],
            ['date' => '2025-08-28', 'level' => 'Moderado', 'score' => 55],
            ['date' => '2025-08-29', 'level' => 'Moderado', 'score' => 50],
        ];
        
        foreach ($riskData as $data) {
            RiskEvaluation::create([
                'evaluation_date' => $data['date'],
                'risk_level' => $data['level'],
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'score' => $data['score'],
                'recommendation' => $this->getRecommendation($data['level']),
                'hourly_data' => json_encode($this->generateHourlyData($data['level']))
            ]);
        }
        
        $this->line('Creados ' . count($riskData) . ' registros de RiskEvaluation para agosto 2025');
        
        // Crear datos de MonthlyRiskData para agosto
        for ($day = 1; $day <= 31; $day++) {
            $date = Carbon::create(2025, 8, $day);
            
            // Solo días laborables (lunes a viernes)
            if ($date->isWeekday()) {
                // Determinar nivel de riesgo basado en la semana del mes
                $riskLevel = $this->getRiskLevelForDay($day);
                
                MonthlyRiskData::create([
                    'year' => 2025,
                    'month' => 8,
                    'day' => $day,
                    'risk_level' => $riskLevel,
                    'status' => 'evaluado',
                    'total_consumption' => rand(1500, 4500),
                    'max_demand' => rand(150, 450),
                    'power_factor' => rand(85, 98) / 100,
                    'total_cost' => rand(800, 180),
                    'efficiency_percentage' => rand(75, 92)
                ]);
            }
        }
        
        $this->line('Creados registros de MonthlyRiskData para agosto 2025');
    }
    
    /**
     * Generar datos horarios según el nivel de riesgo
     */
    private function generateHourlyData($riskLevel)
    {
        $baseData = [
            '08:00' => 20,
            '09:00' => 30,
            '10:00' => 40,
            '11:00' => 50,
            '12:00' => 60,
            '13:00' => 50,
            '14:00' => 40,
            '15:00' => 30,
            '16:00' => 20,
        ];
        
        $multipliers = [
            'Bajo' => 0.7,
            'Moderado' => 1.0,
            'Alto' => 1.5,
            'Crítico' => 2.0
        ];
        
        $multiplier = $multipliers[$riskLevel] ?? 1.0;
        
        $hourlyData = [];
        foreach ($baseData as $hour => $value) {
            $hourlyData[$hour] = min(100, max(0, round($value * $multiplier * (rand(90, 110) / 100))));
        }
        
        return $hourlyData;
    }
    
    /**
     * Obtener recomendación según nivel de riesgo
     */
    private function getRecommendation($riskLevel)
    {
        $recommendations = [
            'Bajo' => 'Mantener patrones actuales. Operaciones normales.',
            'Moderado' => 'Optimizar horarios. Revisar aires acondicionados.',
            'Alto' => 'Limitar equipos no esenciales. Monitorear cada 15 min.',
            'Crítico' => 'Reducir consumo inmediatamente. Protocolo de emergencia.'
        ];
        
        return $recommendations[$riskLevel] ?? 'Recomendación general de eficiencia energética.';
    }
    
    /**
     * Obtener nivel de riesgo según el día del mes
     */
    private function getRiskLevelForDay($day)
    {
        if ($day >= 1 && $day <= 7) return 'Moderado';      // Primera semana
        if ($day >= 8 && $day <= 14) return 'Alto';      // Segunda semana
        if ($day >= 15 && $day <= 21) return 'Moderado';    // Tercera semana
        if ($day >= 22 && $day <= 31) return 'Bajo';     // Cuarta semana
        return 'Moderado';
    }
}
