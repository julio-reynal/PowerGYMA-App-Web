<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiskEvaluation;
use App\Models\MonthlyRiskData;
use Carbon\Carbon;

class QuickTestSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $twoDaysAgo = Carbon::today()->subDays(2);

        // Hourly synthetic series helpers
        $makeFlat = function(int $val): array {
            $arr = [];
            for ($h = 0; $h < 24; $h++) {
                $arr[sprintf('%02d:00', $h)] = $val;
            }
            return $arr;
        };
        $makePeak = function(int $startH, int $endH, int $low=20, int $mid=50, int $high=80): array {
            $arr = [];
            for ($h = 0; $h < 24; $h++) {
                if ($h < $startH) $val=$low;
                elseif ($h == $startH) $val=$mid;
                elseif ($h >= $startH+1 && $h <= $endH+1) $val=$high;
                elseif ($h == $endH+2) $val=$mid;
                else $val=$low;
                $arr[sprintf('%02d:00', $h)] = $val;
            }
            return $arr;
        };

        // RiskEvaluations for today and yesterday
        RiskEvaluation::updateOrCreate(
            ['evaluation_date' => $today->toDateString()],
            [
                'risk_level' => 'Moderado',
                'start_time' => '18:00',
                'end_time' => '19:00',
                'notes' => 'Semilla rápida - hoy',
                'hourly_data' => $makePeak(18, 19)
            ]
        );

        RiskEvaluation::updateOrCreate(
            ['evaluation_date' => $yesterday->toDateString()],
            [
                'risk_level' => 'Alto',
                'start_time' => '19:00',
                'end_time' => '20:00',
                'notes' => 'Semilla rápida - ayer',
                'hourly_data' => $makePeak(19, 20)
            ]
        );

        // MonthlyRiskData for 3 consecutive days
        $map = [
            $twoDaysAgo->toDateString() => 'Bajo',
            $yesterday->toDateString() => 'Alto',
            $today->toDateString() => 'Moderado',
        ];
        foreach ($map as $dateStr => $level) {
            $d = Carbon::parse($dateStr);
            MonthlyRiskData::updateOrCreate(
                [
                    'year' => $d->year,
                    'month' => $d->month,
                    'day' => $d->day,
                ],
                [
                    'risk_level' => $level,
                    'status' => 'evaluado',
                ]
            );
        }
    }
}
