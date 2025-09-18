<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provincia extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'provincias';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'departamento_id',
        'nombre',
        'codigo',
        'activo',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'activo' => 'boolean',
        'departamento_id' => 'integer',
    ];

    /**
     * Relación con departamento
     */
    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    /**
     * Relación con empresas
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Scope para provincias activas
     */
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para buscar por departamento
     */
    public function scopeByDepartamento($query, $departamentoId)
    {
        return $query->where('departamento_id', $departamentoId);
    }

    /**
     * Scope para buscar por código
     */
    public function scopeByCodigo($query, $codigo)
    {
        return $query->where('codigo', $codigo);
    }

    /**
     * Scope para buscar por nombre
     */
    public function scopeByNombre($query, $nombre)
    {
        return $query->where('nombre', 'like', '%' . $nombre . '%');
    }

    /**
     * Scope para provincias activas de un departamento específico
     */
    public function scopeActivasByDepartamento($query, $departamentoId)
    {
        return $query->where('departamento_id', $departamentoId)
                    ->where('activo', true);
    }
}
