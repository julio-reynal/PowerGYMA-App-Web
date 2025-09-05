<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiskSetting;
use App\Models\RiskEvaluation;
use App\Models\MonthlyRiskData;

class RiskSystemSeeder extends Seeder
{
    public function run(): void
    {
        // Configurar niveles de riesgo con colores exactos de la imagen
        $riskSettings = [
            [
                'risk_level' => 'Muy Bajo',
                'color_code' => '#10B981',
                'percentage_min' => 0,
                'percentage_max' => 20,
                'description' => 'Riesgo muy bajo - Condiciones óptimas'
            ],
            [
                'risk_level' => 'Bajo',
                'color_code' => '#10B981',
                'percentage_min' => 21,
                'percentage_max' => 35,
                'description' => 'Riesgo bajo - Condiciones favorables'
            ],
            [
                'risk_level' => 'Moderado',
                'color_code' => '#F59E0B',
                'percentage_min' => 36,
                'percentage_max' => 50,
                'description' => 'Riesgo moderado - Precaución recomendada'
            ],
            [
                'risk_level' => 'Alto',
                'color_code' => '#F97316',
                'percentage_min' => 51,
                'percentage_max' => 65,
                'description' => 'Riesgo alto - Medidas preventivas necesarias'
            ],
            [
                'risk_level' => 'Crítico',
                'color_code' => '#EF4444',
                'percentage_min' => 66,
                'percentage_max' => 100,
                'description' => 'Riesgo crítico - Acción inmediata requerida'
            ],
            [
                'risk_level' => 'No procede',
                'color_code' => '#6B7280',
                'percentage_min' => 0,
                'percentage_max' => 0,
                'description' => 'Evaluación no aplicable para este día'
            ]
        ];

        foreach ($riskSettings as $setting) {
            RiskSetting::updateOrCreate(
                ['risk_level' => $setting['risk_level']],
                $setting
            );
        }

        // Crear datos de ejemplo para el mes actual
        $this->createSampleData();
    }

    private function createSampleData()
    {
        // Evaluación del día actual (25 de agosto como en la imagen)
        $today = now();
        
        // Datos por hora para el gráfico (como en la imagen)
        $hourlyData = [
            '00:00' => 15, '01:00' => 12, '02:00' => 10, '03:00' => 8,
            '04:00' => 10, '05:00' => 15, '06:00' => 25, '07:00' => 35,
            '08:00' => 40, '09:00' => 45, '10:00' => 50, '11:00' => 42,
            '12:00' => 38, '13:00' => 35, '14:00' => 55, '15:00' => 65,
            '16:00' => 70, '17:00' => 75, '18:00' => 80, '19:00' => 85,
            '20:00' => 90, '21:00' => 85, '22:00' => 70, '23:00' => 50
        ];

        RiskEvaluation::updateOrCreate(
            ['evaluation_date' => $today->format('Y-m-d')],
            [
                'risk_level' => 'Alto',
                'start_time' => '19:00',
                'end_time' => '20:00',
                'notes' => 'Evaluación de riesgo diario - Nivel alto detectado en horario nocturno',
                'hourly_data' => $hourlyData
            ]
        );

        // Datos del calendario mensual (agosto 2025)
        $monthlyData = [
            1 => 'Bajo', 2 => 'Alto', 3 => 'Moderado', 4 => 'Bajo', 5 => 'Moderado',
            6 => 'Alto', 7 => 'Bajo', 8 => 'Bajo', 9 => 'Alto', 10 => 'Moderado',
            11 => 'Bajo', 12 => 'Alto', 13 => 'Moderado', 14 => 'Alto', 15 => 'Bajo',
            16 => 'Alto', 17 => 'Alto', 18 => 'Bajo', 19 => 'Moderado', 20 => 'Alto',
            21 => 'Alto', 22 => 'Bajo', 23 => 'Alto', 24 => 'Moderado', 25 => 'Alto',
            26 => 'Moderado', 27 => 'Alto', 28 => 'Bajo', 29 => 'Bajo', 30 => 'Alto', 31 => 'Moderado'
        ];

        foreach ($monthlyData as $day => $riskLevel) {
            MonthlyRiskData::updateOrCreate(
                [
                    'year' => 2025,
                    'month' => 8,
                    'day' => $day
                ],
                [
                    'risk_level' => $riskLevel,
                    'status' => $day <= $today->day ? 'evaluado' : 'pendiente'
                ]
            );
        }
    }
}
