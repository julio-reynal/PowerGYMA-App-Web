<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonthlyRiskData extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'day',
        'risk_level',
        'status',
        'total_consumption',
        'max_demand',
        'power_factor',
        'total_cost',
        'efficiency_percentage'
    ];

    // Obtener datos del mes actual
    public static function currentMonth()
    {
        return self::where('year', now()->year)
                   ->where('month', now()->month)
                   ->orderBy('day')
                   ->get();
    }

    // Obtener datos de un mes específico
    public static function getMonth($year, $month)
    {
        return self::where('year', $year)
                   ->where('month', $month)
                   ->orderBy('day')
                   ->get();
    }

    // Verificar si el día ya pasó (para mostrar color en calendario)
    public function shouldShowColor()
    {
        $today = now();
        $thisDate = now()->setYear($this->year)->setMonth($this->month)->setDay($this->day);
        
        return $thisDate->lte($today) && $this->status === 'evaluado';
    }

    // Obtener color basado en el nivel de riesgo
    public function getColorAttribute()
    {
        $colors = [
            'Muy Bajo' => '#10B981', // Verde
            'Bajo' => '#10B981',      // Verde
            'Moderado' => '#F59E0B',  // Amarillo
            'Alto' => '#F97316',      // Naranja
            'Crítico' => '#EF4444',   // Rojo
            'No procede' => '#6B7280' // Gris
        ];

        return $colors[$this->risk_level] ?? '#6B7280';
    }
}
