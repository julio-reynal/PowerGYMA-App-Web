<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiskSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'risk_level',
        'color_code',
        'percentage_min',
        'percentage_max',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Obtener solo configuraciones activas
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Obtener configuración por nivel de riesgo
    public static function getByLevel($level)
    {
        return self::where('risk_level', $level)->where('is_active', true)->first();
    }

    // Obtener todas las configuraciones ordenadas por porcentaje
    public static function getAllOrdered()
    {
        return self::active()->orderBy('percentage_min')->get();
    }
}
