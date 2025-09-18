<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'departamentos';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nombre',
        'codigo',
        'activo',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación con provincias
     */
    public function provincias(): HasMany
    {
        return $this->hasMany(Provincia::class);
    }

    /**
     * Relación con provincias activas
     */
    public function provinciasActivas(): HasMany
    {
        return $this->hasMany(Provincia::class)->where('activo', true);
    }

    /**
     * Relación con empresas
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Scope para departamentos activos
     */
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
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
}
