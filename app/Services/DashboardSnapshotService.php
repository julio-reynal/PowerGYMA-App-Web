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
        $todayEval = RiskEvaluation::today() ?? RiskEvaluation::orderBy('evaluation_date', 'desc')->first();
        $map = config('risk.percentages');
        $riskLevel = $todayEval?->risk_level ?? null;
        $latestMonth = null;
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
        $low=20; $mid=50; $high=80;
        for ($h=0; $h<24; $h++) {
            $key = sprintf('%02d:00', $h);
            $labels[] = $key;
            if (is_array($hourly) && isset($hourly[$key])) {
                $series[] = (int)$hourly[$key];
            } elseif ($startH!==null && $endH!==null) {
                if ($h < $startH) $series[]=$low;
                elseif ($h == $startH) $series[]=$mid;
                elseif ($h >= $startH+1 && $h <= $endH+1) $series[]=$high;
                elseif ($h == $endH+2) $series[]=$mid;
                else $series[]=$low;
            } else {
                $series[] = $riskPercent;
            }
        }
        $peakFrom = $startH!==null ? sprintf('%02d:00',$startH+1) : null;
        $peakTo = $endH!==null ? sprintf('%02d:00',$endH+1) : null;

        // Datos del mes actual para el calendario (día -> nivel)
        $year = now()->year; $month = now()->month;
        $monthItems = MonthlyRiskData::getMonth($year, $month);
        $monthData = [];
        foreach ($monthItems as $m) {
            $monthData[(int)$m->day] = $m->risk_level; // puede ser null (pendiente)
        }

        return [
            'todayEvalDate' => $todayEval?->evaluation_date ? Carbon::parse($todayEval->evaluation_date)->toDateString() : null,
            'riskLevel' => $riskLevel,
            'riskPercent' => $riskPercent,
            'labels' => $labels,
            'series' => $series,
            'peakFrom' => $peakFrom,
            'peakTo' => $peakTo,
            'hasToday' => $todayEval !== null,
            'hasMonthly' => $monthItems->count() > 0,
            'monthYear' => ['year' => $year, 'month' => $month],
            'monthData' => $monthData,
            'updatedAt' => now()->toIso8601String(),
        ];
    }
}
