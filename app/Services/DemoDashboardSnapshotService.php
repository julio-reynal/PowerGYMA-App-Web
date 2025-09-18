<?php

namespace App\Services;

use App\Models\MonthlyRiskData;
use App\Models\RiskEvaluation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DemoDashboardSnapshotService
{
    const CACHE_KEY = 'demo_dashboard_snapshot';

    public function getCachedOrBuild(): array
    {
        $snapshot = Cache::get(self::CACHE_KEY);
        if (!$snapshot) {
            $snapshot = $this->buildSnapshot();
            // Guardar en caché por 1 hora en lugar de para siempre
            Cache::put(self::CACHE_KEY, $snapshot, now()->addHour());
        }
        return $snapshot;
    }

    public function refreshCache(): array
    {
        $snapshot = $this->buildSnapshot();
        Cache::forget(self::CACHE_KEY);
        // Guardar en caché por 1 hora en lugar de para siempre
        Cache::put(self::CACHE_KEY, $snapshot, now()->addHour());
        return $snapshot;
    }

    public function buildSnapshot(): array
    {
        // LÓGICA DEMO: Usar datos del MES PASADO, no del mes actual
        $lastMonth = now()->subMonth(); // Agosto si estamos en septiembre
        $year = $lastMonth->year;
        $month = $lastMonth->month;
        
        // Buscar datos del mes pasado
        $demoData = $this->getLastMonthData($year, $month);
        
        if (!$demoData) {
            // Si no hay datos del mes pasado, generar datos simulados
            $demoData = $this->generateSimulatedData($year, $month);
        }
        
        $map = config('risk.percentages');
        $riskLevel = $demoData['risk_level'] ?? 'Medio';
        $riskPercent = $map[$riskLevel] ?? 50;

        // Generar serie de datos para gráfico de 24 horas
        $chartData = $this->generateChartData($riskPercent, $demoData);
        
        // Generar datos del mes para calendario
        $monthData = $this->getMonthCalendarData($year, $month);

        return [
            'todayEvalDate' => $demoData['reference_date'] ?? null,
            'isFromToday' => false, // NUNCA es de hoy en modo demo
            'dataSource' => $demoData['source'] ?? 'simulado',
            'demoInfo' => [
                'month_name' => $lastMonth->format('F Y'), // "August 2025"
                'month_spanish' => $this->getSpanishMonth($month) . ' ' . $year,
                'is_simulated' => $demoData['is_simulated'] ?? true,
                'data_count' => $demoData['data_count'] ?? 0
            ],
            'riskLevel' => $riskLevel,
            'riskPercent' => $riskPercent,
            'labels' => $chartData['labels'],
            'series' => $chartData['series'],
            'peakFrom' => $chartData['peakFrom'],
            'peakTo' => $chartData['peakTo'],
            'hasToday' => false,
            'hasMonthly' => count($monthData) > 0,
            'monthYear' => ['year' => $year, 'month' => $month],
            'monthData' => $monthData,
            'updatedAt' => now()->toIso8601String(),
            'isDemoMode' => true
        ];
    }

    /**
     * Buscar datos reales del mes pasado
     */
    private function getLastMonthData(int $year, int $month): ?array
    {
        // 1. Buscar en RiskEvaluation del mes pasado
        $evalData = RiskEvaluation::whereYear('evaluation_date', $year)
            ->whereMonth('evaluation_date', $month)
            ->orderBy('evaluation_date', 'desc')
            ->first();

        if ($evalData) {
            return [
                'risk_level' => $evalData->risk_level,
                'reference_date' => $evalData->evaluation_date,
                'start_time' => $evalData->start_time,
                'end_time' => $evalData->end_time,
                'source' => 'datos_reales_mes_pasado',
                'is_simulated' => false,
                'data_count' => 1
            ];
        }

        // 2. Buscar en MonthlyRiskData del mes pasado
        $monthlyData = MonthlyRiskData::where('year', $year)
            ->where('month', $month)
            ->whereNotNull('risk_level')
            ->orderBy('day', 'desc')
            ->first();

        if ($monthlyData) {
            return [
                'risk_level' => $monthlyData->risk_level,
                'reference_date' => Carbon::create($year, $month, $monthlyData->day)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'source' => 'monthly_data_mes_pasado',
                'is_simulated' => false,
                'data_count' => MonthlyRiskData::where('year', $year)->where('month', $month)->count()
            ];
        }

        return null;
    }

    /**
     * Generar datos simulados realistas para el mes pasado
     */
    private function generateSimulatedData(int $year, int $month): array
    {
        $riskLevels = ['Bajo', 'Medio', 'Alto'];
        $selectedRisk = $riskLevels[array_rand($riskLevels)];
        
        // Generar fecha de referencia del mes pasado
        $referenceDay = rand(15, 25); // Día medio-final del mes
        $referenceDate = Carbon::create($year, $month, $referenceDay);

        return [
            'risk_level' => $selectedRisk,
            'reference_date' => $referenceDate->toDateString(),
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
            'source' => 'simulado',
            'is_simulated' => true,
            'data_count' => rand(15, 25)
        ];
    }

    /**
     * Generar datos para gráfico de 24 horas
     */
    private function generateChartData(int $riskPercent, array $demoData): array
    {
        $labels = [];
        $series = [];
        
        $startH = $demoData['start_time'] ? (int) Carbon::parse($demoData['start_time'])->format('H') : 8;
        $endH = $demoData['end_time'] ? (int) Carbon::parse($demoData['end_time'])->format('H') : 16;
        
        // Crear curva realista para horarios laborales
        for ($h = 0; $h < 24; $h++) {
            $key = sprintf('%02d:00', $h);
            $labels[] = $key;
            
            if ($h < $startH) {
                // Antes del horario laboral: valores muy bajos
                $series[] = round($riskPercent * 0.05);
            } elseif ($h >= $startH && $h <= $endH) {
                // Durante horario laboral: valores altos con variación realista
                $midPoint = ($startH + $endH) / 2;
                $distance = abs($h - $midPoint);
                $maxDistance = ($endH - $startH) / 2;
                
                // Crear curva que sube hacia el mediodía y baja hacia el final
                $factor = 1 - ($distance / max(1, $maxDistance)) * 0.4;
                $randomVariation = (rand(85, 115) / 100); // Variación ±15%
                $value = round($riskPercent * $factor * $randomVariation);
                $series[] = max(0, min(100, $value)); // Mantener en rango 0-100
            } else {
                // Después del horario laboral: valores bajos
                $series[] = round($riskPercent * 0.1);
            }
        }

        return [
            'labels' => $labels,
            'series' => $series,
            'peakFrom' => sprintf('%02d:00', $startH),
            'peakTo' => sprintf('%02d:00', $endH)
        ];
    }

    /**
     * Obtener datos del calendario para el mes pasado
     */
    private function getMonthCalendarData(int $year, int $month): array
    {
        // Usar datos reales si existen
        $realData = MonthlyRiskData::where('year', $year)
            ->where('month', $month)
            ->get();
        
        $monthData = [];
        foreach ($realData as $item) {
            if ($item->risk_level) {
                $monthData[(int)$item->day] = $item->risk_level;
            }
        }

        // Si no hay suficientes datos reales, simular algunos días
        if (count($monthData) < 10) {
            $riskLevels = ['Bajo', 'Medio', 'Alto'];
            $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
            
            for ($day = 1; $day <= $daysInMonth; $day++) {
                if (!isset($monthData[$day])) {
                    // Simular solo días laborales
                    $dayOfWeek = Carbon::create($year, $month, $day)->dayOfWeek;
                    if ($dayOfWeek >= 1 && $dayOfWeek <= 5) { // Lunes a Viernes
                        // 70% probabilidad de tener datos
                        if (rand(1, 100) <= 70) {
                            $monthData[$day] = $riskLevels[array_rand($riskLevels)];
                        }
                    }
                }
            }
        }

        return $monthData;
    }

    /**
     * Obtener nombre del mes en español
     */
    private function getSpanishMonth(int $month): string
    {
        $months = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        
        return $months[$month] ?? 'Mes';
    }
}
