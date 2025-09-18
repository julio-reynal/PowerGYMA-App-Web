<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'expires_at',
        'is_active',
        'company_id',
        'puesto_trabajo',
        'telefono_celular',
        'comentarios_adicionales',
        'tipo_documento',
        'numero_documento',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'genero',
        // Campos de empresa duplicados en la tabla users
        'ruc_empresa',
        'giro_empresa',
        'razon_social',
        'telefono_fijo',
        'departamento_id',
        'provincia_id',
        'direccion_empresa',
        'distrito',
        'company_name',
        'company_cuit',
        'company_address',
        'company_phone',
        'company_activity',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'expires_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'company_id' => 'integer',
            // Nuevos casts FASE 5
            'fecha_nacimiento' => 'date',
            'departamento_id' => 'integer',
            'provincia_id' => 'integer',
        ];
    }

    /**
     * Normalizar el rol a minúsculas al asignarlo.
     */
    public function setRoleAttribute($value): void
    {
        $this->attributes['role'] = is_string($value) ? strtolower($value) : $value;
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin(): bool
    {
    return strtolower((string)$this->role) === 'admin';
    }

    /**
     * Verificar si el usuario es cliente
     */
    public function isCliente(): bool
    {
    return strtolower((string)$this->role) === 'cliente';
    }

    /**
     * Verificar si el usuario es demo
     */
    public function isDemo(): bool
    {
    return strtolower((string)$this->role) === 'demo';
    }

    /**
     * Verificar si el usuario está activo y no ha expirado
     */
    public function isActiveAndNotExpired(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Scope para usuarios activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Relación con empresa
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Accessor para obtener información completa del usuario
     */
    public function getInfoCompletaAttribute(): array
    {
        return [
            'usuario' => [
                'id' => $this->id,
                'nombre' => $this->name,
                'email' => $this->email,
                'telefono_celular' => $this->telefono_celular,
                'rol' => $this->role,
                'activo' => $this->is_active,
                'expira' => $this->expires_at?->format('Y-m-d'),
                'comentarios' => $this->comentarios_adicionales,
            ],
            'empresa' => $this->company ? [
                'id' => $this->company->id,
                'ruc' => $this->company->ruc,
                'razon_social' => $this->company->razon_social,
                'telefono_fijo' => $this->company->telefono_fijo,
                'direccion_completa' => $this->company->direccion_completa,
                'departamento' => $this->company->departamento?->nombre,
                'provincia' => $this->company->provincia?->nombre,
                'direccion_calle' => $this->company->direccion_calle,
            ] : null,
        ];
    }

    /**
     * Scope para buscar usuarios por empresa
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope para buscar usuarios por RUC de empresa
     */
    public function scopeByCompanyRuc($query, $ruc)
    {
        return $query->whereHas('company', function($q) use ($ruc) {
            $q->where('ruc', $ruc);
        });
    }

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
     * Verificar si el documento es único
     */
    public static function isDocumentUnique($tipoDocumento, $numeroDocumento, $excludeUserId = null): bool
    {
        $query = static::where('tipo_documento', $tipoDocumento)
                      ->where('numero_documento', $numeroDocumento);
                      
        if ($excludeUserId) {
            $query->where('id', '!=', $excludeUserId);
        }
        
        return $query->count() === 0;
    }

    /**
     * Obtener nombre completo con documento
     */
    public function getFullIdentificationAttribute(): string
    {
        $identification = $this->name;
        
        if ($this->tipo_documento && $this->numero_documento) {
            $identification .= " ({$this->tipo_documento}: {$this->numero_documento})";
        }
        
        return $identification;
    }
}
