<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiskEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_date',
        'risk_level',
        'start_time',
        'end_time',
        'notes',
        'hourly_data',
        'total_consumption',
        'max_demand',
        'power_factor',
        'total_cost',
        'efficiency_percentage',
        'observations'
    ];

    protected $casts = [
        'evaluation_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'hourly_data' => 'array'
    ];

    // Obtener evaluación del día actual
    public static function today()
    {
        return self::whereDate('evaluation_date', today())->first();
    }

    // Obtener evaluaciones del mes actual
    public static function currentMonth()
    {
        return self::whereYear('evaluation_date', now()->year)
                   ->whereMonth('evaluation_date', now()->month)
                   ->orderBy('evaluation_date')
                   ->get();
    }

    // Verificar si es riesgo alto
    public function isHighRisk()
    {
        return in_array($this->risk_level, ['Alto', 'Crítico']);
    }
}
