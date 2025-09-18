<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemoRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'telefono_celular',
        'tipo_documento',
        'numero_documento',
        'empresa',
        'ruc_empresa',
        'giro_empresa',
        'cargo_puesto',
        'direccion',
        'ciudad',
        'departamento_id',
        'provincia_id',
        'tipo_demo',
        'comentarios',
        'necesidades_especificas',
        'estado',
        'fecha_contacto',
        'fecha_demo_programada',
        'notas_internas',
        'acepta_terminos',
        'acepta_marketing',
        'origen_solicitud',
    ];

    protected $attributes = [
        'estado' => 'pendiente',
        'tipo_demo' => 'evaluacion',
        'acepta_terminos' => true,
        'acepta_marketing' => false,
        'origen_solicitud' => 'web',
    ];

    protected $casts = [
        'fecha_contacto' => 'datetime',
        'fecha_demo_programada' => 'datetime',
        'acepta_terminos' => 'boolean',
        'acepta_marketing' => 'boolean',
        'departamento_id' => 'integer',
        'provincia_id' => 'integer',
    ];

    // Estados disponibles
    public const ESTADOS = [
        'pendiente' => 'Pendiente',
        'contactado' => 'Contactado',
        'programado' => 'Demo Programada',
        'completado' => 'Completado',
        'rechazado' => 'Rechazado',
    ];

    // Tipos de demo disponibles
    public const TIPOS_DEMO = [
        'evaluacion' => 'Evaluación del Sistema',
        'prueba_gratis' => 'Prueba Gratuita',
        'consultoria' => 'Consultoría Especializada',
        'otro' => 'Otro',
    ];

    // Tipos de documento disponibles
    public const TIPOS_DOCUMENTO = [
        'DNI' => 'DNI',
        'CE' => 'Carnet de Extranjería',
        'Pasaporte' => 'Pasaporte',
        'RUC' => 'RUC',
    ];

    /**
     * Relación con Departamento
     */
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    /**
     * Relación con Provincia
     */
    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopeByEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para solicitudes pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para solicitudes recientes
     */
    public function scopeRecientes($query, $dias = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }

    /**
     * Obtener el estado en español
     */
    public function getEstadoLabelAttribute(): string
    {
        return self::ESTADOS[$this->estado] ?? ($this->estado ?? 'Sin estado');
    }

    /**
     * Obtener el tipo de demo en español
     */
    public function getTipoDemoLabelAttribute(): string
    {
        return self::TIPOS_DEMO[$this->tipo_demo] ?? ($this->tipo_demo ?? 'Sin tipo');
    }

    /**
     * Verificar si la solicitud está pendiente
     */
    public function isPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }

    /**
     * Verificar si la solicitud está completada
     */
    public function isCompletada(): bool
    {
        return $this->estado === 'completado';
    }

    /**
     * Marcar como contactado
     */
    public function marcarComoContactado($notas = null): bool
    {
        $this->estado = 'contactado';
        $this->fecha_contacto = now();
        if ($notas) {
            $this->notas_internas = $notas;
        }
        return $this->save();
    }

    /**
     * Programar demo
     */
    public function programarDemo($fecha, $notas = null): bool
    {
        $this->estado = 'programado';
        $this->fecha_demo_programada = $fecha;
        if ($notas) {
            $this->notas_internas = $notas;
        }
        return $this->save();
    }

    /**
     * Completar demo
     */
    public function completarDemo($notas = null): bool
    {
        $this->estado = 'completado';
        if ($notas) {
            $this->notas_internas = $notas;
        }
        return $this->save();
    }

    /**
     * Obtener información completa de la solicitud
     */
    public function getInfoCompletaAttribute(): array
    {
        return [
            'solicitud' => [
                'id' => $this->id,
                'nombre' => $this->nombre,
                'email' => $this->email,
                'telefono' => $this->telefono_celular ?: $this->telefono,
                'documento' => $this->tipo_documento . ': ' . $this->numero_documento,
                'estado' => $this->estado_label,
                'tipo_demo' => $this->tipo_demo_label,
                'fecha_solicitud' => $this->created_at->format('d/m/Y H:i'),
            ],
            'empresa' => [
                'nombre' => $this->empresa,
                'ruc' => $this->ruc_empresa,
                'giro' => $this->giro_empresa,
                'cargo_solicitante' => $this->cargo_puesto,
            ],
            'ubicacion' => [
                'direccion' => $this->direccion,
                'ciudad' => $this->ciudad,
                'departamento' => $this->departamento?->nombre,
                'provincia' => $this->provincia?->nombre,
            ],
            'seguimiento' => [
                'fecha_contacto' => $this->fecha_contacto?->format('d/m/Y H:i'),
                'fecha_demo' => $this->fecha_demo_programada?->format('d/m/Y H:i'),
                'notas' => $this->notas_internas,
            ],
        ];
    }

    /**
     * Validar si el email es único
     */
    public static function isEmailUnique($email, $excludeId = null): bool
    {
        $query = static::where('email', $email);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->count() === 0;
    }
}
