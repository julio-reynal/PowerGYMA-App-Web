<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'ruc',
        'razon_social',
        'telefono_fijo',
        'departamento_id',
        'provincia_id',
        'direccion_calle',
        'activo',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'activo' => 'boolean',
        'departamento_id' => 'integer',
        'provincia_id' => 'integer',
    ];

    /**
     * Relación con departamento
     */
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    /**
     * Relación con provincia
     */
    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }

    /**
     * Relación con usuarios
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relación con usuarios activos
     */
    public function usersActivos(): HasMany
    {
        return $this->hasMany(User::class)->where('is_active', true);
    }

    /**
     * Scope para empresas activas
     */
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para buscar por RUC
     */
    public function scopeByRuc($query, $ruc)
    {
        return $query->where('ruc', $ruc);
    }

    /**
     * Scope para buscar por razón social
     */
    public function scopeByRazonSocial($query, $razonSocial)
    {
        return $query->where('razon_social', 'like', '%' . $razonSocial . '%');
    }

    /**
     * Scope para buscar por departamento
     */
    public function scopeByDepartamento($query, $departamentoId)
    {
        return $query->where('departamento_id', $departamentoId);
    }

    /**
     * Scope para buscar por provincia
     */
    public function scopeByProvincia($query, $provinciaId)
    {
        return $query->where('provincia_id', $provinciaId);
    }

    /**
     * Accessor para obtener la dirección completa
     */
    public function getDireccionCompletaAttribute(): string
    {
        $direccion = [];
        
        if ($this->direccion_calle) {
            $direccion[] = $this->direccion_calle;
        }
        
        if ($this->provincia && $this->provincia->nombre) {
            $direccion[] = $this->provincia->nombre;
        }
        
        if ($this->departamento && $this->departamento->nombre) {
            $direccion[] = $this->departamento->nombre;
        }
        
        return implode(', ', $direccion);
    }

    /**
     * Accessor para formatear el RUC
     */
    public function getRucFormateadoAttribute(): string
    {
        return $this->ruc ? substr($this->ruc, 0, 2) . '-' . substr($this->ruc, 2) : '';
    }

    /**
     * Mutator para limpiar y validar RUC antes de guardar
     */
    public function setRucAttribute($value): void
    {
        // Remover cualquier carácter que no sea número
        $cleanRuc = preg_replace('/[^0-9]/', '', $value);
        $this->attributes['ruc'] = $cleanRuc;
    }

    /**
     * Método para validar si es un RUC válido de Perú (11 dígitos)
     */
    public function isValidRuc(): bool
    {
        return strlen($this->ruc) === 11 && is_numeric($this->ruc);
    }
}
