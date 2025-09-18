<?php

namespace App\Services;

use App\Models\MonthlyRiskData;
use App\Models\RiskEvaluation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardSnapshotService
{
    const CACHE_KEY = 'cliente_dashboard_snapshot';

    public function getCachedOrBuild(): array
    {
        $snapshot = Cache::get(self::CACHE_KEY);
        if (!$snapshot) {
            $snapshot = $this->buildSnapshot();
            Cache::forever(self::CACHE_KEY, $snapshot);
        }
        return $snapshot;
    }

    public function refreshCache(): array
    {
        $snapshot = $this->buildSnapshot();
        Cache::forget(self::CACHE_KEY);
        Cache::forever(self::CACHE_KEY, $snapshot);
        return $snapshot;
    }

    public function buildSnapshot(): array
    {
        // LÓGICA PRINCIPAL: Priorizar datos de hoy, si no existen usar los más recientes
        $todayEval = RiskEvaluation::whereDate('evaluation_date', today())->first();
        $isFromToday = $todayEval !== null;
        
        // Si no hay datos de hoy, buscar la evaluación más reciente
        if (!$todayEval) {
            $todayEval = RiskEvaluation::orderBy('evaluation_date', 'desc')->first();
        }
        
        $map = config('risk.percentages');
        $riskLevel = $todayEval?->risk_level ?? null;
        $latestMonth = null;
        
        // Si aún no hay datos de RiskEvaluation, usar MonthlyRiskData como respaldo
        if (!$riskLevel) {
            $latestMonth = MonthlyRiskData::orderBy('year','desc')->orderBy('month','desc')->orderBy('day','desc')->first();
            $riskLevel = $latestMonth?->risk_level ?? 'No procede';
        }
        
        $riskPercent = $map[$riskLevel] ?? 0;

        // Serie 24 horas 00..23
        $labels = [];
        $series = [];
        $startH = $todayEval?->start_time ? (int) Carbon::parse($todayEval->start_time)->format('H') : null;
        $endH = $todayEval?->end_time ? (int) Carbon::parse($todayEval->end_time)->format('H') : null;
        $hourly = $todayEval?->hourly_data ?? null;
        
        // Crear curva gradual que empieza en 0% y sube hasta el valor exacto
        $exactValue = $riskPercent; // Valor exacto del nivel de riesgo
        
        for ($h=0; $h<24; $h++) {
            $key = sprintf('%02d:00', $h);
            $labels[] = $key;
            
            // Crear curva suave desde 0% hasta el valor exacto
            if ($startH!==null && $endH!==null) {
                // Curva que alcanza el pico durante el horario especificado
                if ($h < $startH) {
                    // Antes del horario pico: curva gradual ascendente
                    $progress = $h / max(1, $startH); // Progreso de 0 a 1
                    $series[] = round($exactValue * $progress * 0.3); // Sube suavemente hasta 30% del valor
                } elseif ($h >= $startH && $h <= $endH) {
                    // Durante el pico: valor exacto del Excel
                    $series[] = $exactValue;
                } elseif ($h == $endH + 1) {
                    // Hora después del pico: transición suave hacia abajo
                    $series[] = round($exactValue * 0.7);
                } else {
                    // Resto del día: curva descendente suave
                    $hoursAfterPeak = $h - ($endH + 1);
                    $remainingHours = (24 - ($endH + 2));
                    $progress = $hoursAfterPeak / max(1, $remainingHours);
                    $series[] = round($exactValue * (0.7 - ($progress * 0.7))); // Baja gradualmente hacia 0
                }
            } else {
                // Sin horario específico: curva suave durante todo el día
                $progress = ($h <= 12) ? ($h / 12) : ((24 - $h) / 12); // Curva simétrica
                $series[] = round($exactValue * $progress);
            }
        }
        $peakFrom = $startH!==null ? sprintf('%02d:00',$startH) : null;
        $peakTo = $endH!==null ? sprintf('%02d:00',$endH) : null;

        // Datos del mes actual para el calendario (día -> nivel)
        $year = now()->year; $month = now()->month;
        $monthItems = MonthlyRiskData::getMonth($year, $month);
        $monthData = [];
        foreach ($monthItems as $m) {
            $monthData[(int)$m->day] = $m->risk_level; // puede ser null (pendiente)
        }

        return [
            'todayEvalDate' => $todayEval?->evaluation_date ? Carbon::parse($todayEval->evaluation_date)->toDateString() : null,
            'isFromToday' => $isFromToday,
            'dataSource' => $isFromToday ? 'hoy' : ($todayEval ? 'último_disponible' : 'sin_datos'),
            'riskLevel' => $riskLevel,
            'riskPercent' => $riskPercent,
            'labels' => $labels,
            'series' => $series,
            'peakFrom' => $peakFrom,
            'peakTo' => $peakTo,
            'hasToday' => $isFromToday,
            'hasMonthly' => $monthItems->count() > 0,
            'monthYear' => ['year' => $year, 'month' => $month],
            'monthData' => $monthData,
            'updatedAt' => now()->toIso8601String(),
        ];
    }
}
