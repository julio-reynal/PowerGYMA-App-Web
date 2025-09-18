<?php

namespace App\Services;

use App\Models\RiskEvaluation;
use App\Models\MonthlyRiskData;
use App\Models\ExcelUpload;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RiskCalculationService
{
    protected $dashboardService;

    public function __construct(DashboardSnapshotService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Actualizar el sistema de riesgo basado en el tiempo actual
     */
    public function updateRiskByTime()
    {
        $now = Carbon::now();
        $date = $now->toDateString();
        $hour = $now->hour;
        
        // Verificar si ya existe una evaluación para hoy
        $todayEvaluation = RiskEvaluation::today();
        
        if (!$todayEvaluation) {
            // Crear nueva evaluación para hoy
            $todayEvaluation = $this->createDailyEvaluation($date);
        }
        
        // Actualizar datos mensuales para el día actual
        $this->updateMonthlyData($now->year, $now->month, $now->day);
        
        // Actualizar caché del dashboard
        $this->dashboardService->refreshCache();
        
        Log::info("Risk system updated by time", [
            'date' => $date,
            'hour' => $hour,
            'risk_level' => $todayEvaluation->risk_level
        ]);
        
        return $todayEvaluation;
    }

    /**
     * Actualizar el sistema de riesgo basado en datos de Excel subidos
     */
    public function updateRiskByExcelData($excelUploadId = null)
    {
        try {
            // Si se especifica un Excel, usar sus datos
            if ($excelUploadId) {
                $excelUpload = ExcelUpload::find($excelUploadId);
                if ($excelUpload && $excelUpload->processed_data) {
                    $this->processExcelRiskData($excelUpload->processed_data);
                }
            } else {
                // Usar el Excel más reciente
                $latestExcel = ExcelUpload::where('status', 'procesado')
                    ->orderBy('created_at', 'desc')
                    ->first();
                    
                if ($latestExcel && $latestExcel->processed_data) {
                    $this->processExcelRiskData($latestExcel->processed_data);
                }
            }
            
            // Actualizar caché del dashboard
            $this->dashboardService->refreshCache();
            
            Log::info("Risk system updated by Excel data", [
                'excel_id' => $excelUploadId ?? $latestExcel?->id ?? 'none'
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error updating risk by Excel data: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Crear evaluación diaria automática
     */
    protected function createDailyEvaluation($date)
    {
        $now = Carbon::now();
        $hour = $now->hour;
        
        // Determinar nivel de riesgo basado en la hora
        $riskLevel = $this->calculateRiskLevelByTime($hour);
        
        // Generar horarios de pico dinámicamente
        $startTime = $this->generatePeakStartTime();
        $endTime = $this->generatePeakEndTime($startTime);
        
        // Generar datos horarios
        $hourlyData = $this->generateHourlyData($riskLevel, $startTime, $endTime);
        
        return RiskEvaluation::updateOrCreate(
            ['evaluation_date' => $date],
            [
                'risk_level' => $riskLevel,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'hourly_data' => $hourlyData,
                'total_consumption' => $this->generateConsumption(),
                'max_demand' => $this->generateMaxDemand(),
                'power_factor' => $this->generatePowerFactor(),
                'total_cost' => $this->generateTotalCost(),
                'efficiency_percentage' => $this->generateEfficiency($riskLevel),
                'observations' => 'Evaluación automática generada el ' . $now->format('d/m/Y H:i:s'),
                'notes' => $this->generateNotesByRiskLevel($riskLevel)
            ]
        );
    }

    /**
     * Actualizar datos mensuales para un día específico
     */
    protected function updateMonthlyData($year, $month, $day)
    {
        $riskLevel = $this->calculateRiskLevelByTime(Carbon::now()->hour);
        
        return MonthlyRiskData::updateOrCreate(
            [
                'year' => $year,
                'month' => $month,
                'day' => $day
            ],
            [
                'risk_level' => $riskLevel,
                'status' => 'evaluado',
                'total_consumption' => $this->generateConsumption(),
                'max_demand' => $this->generateMaxDemand(),
                'power_factor' => $this->generatePowerFactor(),
                'total_cost' => $this->generateTotalCost(),
                'efficiency_percentage' => $this->generateEfficiency($riskLevel)
            ]
        );
    }

    /**
     * Calcular nivel de riesgo basado en la hora del día
     */
    protected function calculateRiskLevelByTime($hour)
    {
        // Lógica de riesgo basada en horarios típicos de consumo eléctrico
        if ($hour >= 18 && $hour <= 22) {
            // Horario pico nocturno - mayor riesgo
            return $this->randomChoice(['Alto', 'Crítico', 'Moderado'], [0.3, 0.2, 0.5]);
        } elseif ($hour >= 8 && $hour <= 12) {
            // Horario pico matutino - riesgo moderado
            return $this->randomChoice(['Moderado', 'Alto', 'Bajo'], [0.5, 0.3, 0.2]);
        } elseif ($hour >= 13 && $hour <= 17) {
            // Horario tarde - riesgo variable
            return $this->randomChoice(['Moderado', 'Bajo', 'Alto'], [0.4, 0.4, 0.2]);
        } else {
            // Horario valle - menor riesgo
            return $this->randomChoice(['Bajo', 'Muy Bajo', 'Moderado'], [0.5, 0.3, 0.2]);
        }
    }

    /**
     * Procesar datos de riesgo desde Excel
     */
    protected function processExcelRiskData($processedData)
    {
        if (isset($processedData['daily_evaluation'])) {
            $dailyData = $processedData['daily_evaluation'];
            
            RiskEvaluation::updateOrCreate(
                ['evaluation_date' => $dailyData['evaluation_date']],
                [
                    'risk_level' => $dailyData['risk_level'],
                    'start_time' => $dailyData['start_time'],
                    'end_time' => $dailyData['end_time'],
                    'hourly_data' => $dailyData['hourly_data'] ?? null,
                    'total_consumption' => $dailyData['total_consumption'] ?? null,
                    'max_demand' => $dailyData['max_demand'] ?? null,
                    'power_factor' => $dailyData['power_factor'] ?? null,
                    'total_cost' => $dailyData['total_cost'] ?? null,
                    'efficiency_percentage' => $dailyData['efficiency_percentage'] ?? null,
                    'observations' => 'Evaluación basada en datos Excel subidos el ' . now()->format('d/m/Y H:i:s'),
                    'notes' => $dailyData['notes'] ?? null
                ]
            );
        }

        if (isset($processedData['monthly_data'])) {
            foreach ($processedData['monthly_data'] as $monthlyData) {
                MonthlyRiskData::updateOrCreate(
                    [
                        'year' => $monthlyData['year'],
                        'month' => $monthlyData['month'],
                        'day' => $monthlyData['day']
                    ],
                    [
                        'risk_level' => $monthlyData['risk_level'],
                        'status' => 'evaluado',
                        'total_consumption' => $monthlyData['total_consumption'] ?? null,
                        'max_demand' => $monthlyData['max_demand'] ?? null,
                        'power_factor' => $monthlyData['power_factor'] ?? null,
                        'total_cost' => $monthlyData['total_cost'] ?? null,
                        'efficiency_percentage' => $monthlyData['efficiency_percentage'] ?? null
                    ]
                );
            }
        }
    }

    /**
     * Generar horario de inicio de pico
     */
    protected function generatePeakStartTime()
    {
        // Horarios típicos de pico: 18:00-19:00
        $startHour = rand(18, 19);
        return Carbon::createFromTime($startHour, 0, 0)->format('H:i:s');
    }

    /**
     * Generar horario de fin de pico
     */
    protected function generatePeakEndTime($startTime)
    {
        $start = Carbon::createFromTimeString($startTime);
        $endHour = $start->hour + rand(1, 3); // 1 a 3 horas de duración
        return Carbon::createFromTime(min($endHour, 23), 0, 0)->format('H:i:s');
    }

    /**
     * Generar datos horarios realistas
     */
    protected function generateHourlyData($riskLevel, $startTime, $endTime)
    {
        $hourlyData = [];
        $start = Carbon::createFromTimeString($startTime);
        $end = Carbon::createFromTimeString($endTime);
        
        $baseValues = [
            'Muy Bajo' => 20,
            'Bajo' => 35,
            'Moderado' => 50,
            'Alto' => 75,
            'Crítico' => 90
        ];
        
        $baseValue = $baseValues[$riskLevel] ?? 50;
        
        for ($hour = 0; $hour < 24; $hour++) {
            $time = sprintf('%02d:00', $hour);
            
            if ($hour >= $start->hour && $hour <= $end->hour) {
                // Horario pico - valores más altos
                $value = $baseValue + rand(10, 25);
            } elseif ($hour >= 6 && $hour <= 18) {
                // Horario diurno - valores medios
                $value = $baseValue + rand(-10, 10);
            } else {
                // Horario nocturno - valores más bajos
                $value = $baseValue + rand(-20, 5);
            }
            
            $hourlyData[$time] = max(10, min(100, $value));
        }
        
        return $hourlyData;
    }

    /**
     * Métodos auxiliares para generar datos realistas
     */
    protected function generateConsumption()
    {
        return rand(1200, 2500) + (rand(0, 99) / 100); // kWh
    }

    protected function generateMaxDemand()
    {
        return rand(150, 350) + (rand(0, 99) / 100); // kW
    }

    protected function generatePowerFactor()
    {
        return 0.85 + (rand(0, 15) / 100); // 0.85 - 1.00
    }

    protected function generateTotalCost()
    {
        return rand(800, 1800) + (rand(0, 99) / 100); // Soles
    }

    protected function generateEfficiency($riskLevel)
    {
        $baseEfficiency = [
            'Muy Bajo' => 95,
            'Bajo' => 90,
            'Moderado' => 85,
            'Alto' => 75,
            'Crítico' => 65
        ];
        
        $base = $baseEfficiency[$riskLevel] ?? 85;
        return $base + rand(-5, 5);
    }

    protected function generateNotesByRiskLevel($riskLevel)
    {
        $notes = [
            'Muy Bajo' => 'Consumo óptimo. Sistema funcionando eficientemente.',
            'Bajo' => 'Consumo dentro de parámetros normales.',
            'Moderado' => 'Consumo elevado. Revisar equipos de mayor demanda.',
            'Alto' => 'Consumo crítico. Implementar medidas de ahorro urgentes.',
            'Crítico' => 'Consumo extremo. Revisar sistema eléctrico inmediatamente.'
        ];
        
        return $notes[$riskLevel] ?? 'Sin observaciones específicas.';
    }

    /**
     * Método auxiliar para selección aleatoria ponderada
     */
    protected function randomChoice($choices, $weights)
    {
        $rand = rand(1, 100) / 100;
        $total = 0;
        
        for ($i = 0; $i < count($choices); $i++) {
            $total += $weights[$i];
            if ($rand <= $total) {
                return $choices[$i];
            }
        }
        
        return $choices[0];
    }

    /**
     * Limpiar datos antiguos (opcional)
     */
    public function cleanOldData($daysToKeep = 30)
    {
        $cutoffDate = Carbon::now()->subDays($daysToKeep);
        
        RiskEvaluation::where('evaluation_date', '<', $cutoffDate)->delete();
        
        $cutoffMonth = $cutoffDate->month;
        $cutoffYear = $cutoffDate->year;
        
        MonthlyRiskData::where('year', '<', $cutoffYear)
            ->orWhere(function ($query) use ($cutoffYear, $cutoffMonth) {
                $query->where('year', $cutoffYear)->where('month', '<', $cutoffMonth);
            })
            ->delete();
            
        Log::info("Cleaned old risk data older than $daysToKeep days");
    }
}