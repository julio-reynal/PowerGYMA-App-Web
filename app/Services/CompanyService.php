<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanyService
{
    /**
     * Buscar empresa por RUCs
     */
    public function findByRuc(string $ruc): ?Company
    {
        try {
            // Limpiar el RUC de cualquier formato
            $cleanRuc = $this->cleanRuc($ruc);
            
            if (!$this->isValidRuc($cleanRuc)) {
                return null;
            }
            
            return Company::with(['departamento', 'provincia'])
                         ->where('ruc', $cleanRuc)
                         ->where('activo', true)
                         ->first();
                         
        } catch (\Exception $e) {
            Log::error('Error al buscar empresa por RUC: ' . $e->getMessage(), [
                'ruc' => $ruc,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }
    
    /**
     * Crear o actualizar empresa
     */
    public function createOrUpdate(array $data): Company
    {
        try {
            DB::beginTransaction();
            
            // Limpiar y validar RUC
            $data['ruc'] = $this->cleanRuc($data['ruc']);
            
            if (!$this->isValidRuc($data['ruc'])) {
                throw new \InvalidArgumentException('RUC inválido: debe tener 11 dígitos');
            }
            
            // Buscar empresa existente
            $company = Company::where('ruc', $data['ruc'])->first();
            
            if ($company) {
                // Actualizar empresa existente
                $company->update($data);
                Log::info('Empresa actualizada', ['ruc' => $data['ruc']]);
            } else {
                // Crear nueva empresa
                $company = Company::create($data);
                Log::info('Nueva empresa creada', ['ruc' => $data['ruc']]);
            }
            
            DB::commit();
            
            // Recargar con relaciones
            return $company->load(['departamento', 'provincia']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear/actualizar empresa: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    
    /**
     * Obtener datos completos de empresa para autocompletado
     */
    public function getCompanyData(string $ruc): ?array
    {
        $company = $this->findByRuc($ruc);
        
        if (!$company) {
            return null;
        }
        
        return [
            'id' => $company->id,
            'ruc' => $company->ruc,
            'ruc_formateado' => $company->ruc_formateado,
            'razon_social' => $company->razon_social,
            'telefono_fijo' => $company->telefono_fijo,
            'departamento' => [
                'id' => $company->departamento?->id,
                'nombre' => $company->departamento?->nombre,
                'codigo' => $company->departamento?->codigo,
            ],
            'provincia' => [
                'id' => $company->provincia?->id,
                'nombre' => $company->provincia?->nombre,
                'codigo' => $company->provincia?->codigo,
            ],
            'distrito' => $company->distrito,
            'direccion_calle' => $company->direccion_calle,
            'direccion_completa' => $company->direccion_completa,
            'usuarios_count' => $company->users()->count(),
            'activo' => $company->activo,
            'created_at' => $company->created_at->format('Y-m-d H:i:s'),
        ];
    }
    
    /**
     * Buscar empresas por razón social (para sugerencias)
     */
    public function searchByRazonSocial(string $query, int $limit = 10): Collection
    {
        try {
            return Company::with(['departamento', 'provincia'])
                         ->where('razon_social', 'like', '%' . $query . '%')
                         ->where('activo', true)
                         ->orderBy('razon_social')
                         ->limit($limit)
                         ->get();
                         
        } catch (\Exception $e) {
            Log::error('Error al buscar empresas por razón social: ' . $e->getMessage());
            return new Collection();
        }
    }
    
    /**
     * Obtener estadísticas de empresa
     */
    public function getCompanyStats(Company $company): array
    {
        try {
            $stats = [
                'usuarios_total' => $company->users()->count(),
                'usuarios_activos' => $company->users()->where('is_active', true)->count(),
                'usuarios_admin' => $company->users()->where('role', 'admin')->count(),
                'usuarios_cliente' => $company->users()->where('role', 'cliente')->count(),
                'usuarios_demo' => $company->users()->where('role', 'demo')->count(),
                'ultimo_usuario_creado' => $company->users()->latest()->first()?->created_at?->format('Y-m-d'),
            ];
            
            return $stats;
            
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas de empresa: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Verificar si una empresa puede ser eliminada
     */
    public function canBeDeleted(Company $company): bool
    {
        return $company->users()->count() === 0;
    }
    
    /**
     * Desactivar empresa (soft delete)
     */
    public function deactivate(Company $company): bool
    {
        try {
            DB::beginTransaction();
            
            // Desactivar empresa
            $company->update(['activo' => false]);
            
            // Desactivar usuarios asociados
            $company->users()->update(['is_active' => false]);
            
            DB::commit();
            
            Log::info('Empresa desactivada', ['company_id' => $company->id, 'ruc' => $company->ruc]);
            
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al desactivar empresa: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Limpiar RUC de formato (quitar guiones, espacios, etc.)
     */
    private function cleanRuc(string $ruc): string
    {
        return preg_replace('/[^0-9]/', '', $ruc);
    }
    
    /**
     * Validar que el RUC sea válido (11 dígitos numéricos)
     */
    private function isValidRuc(string $ruc): bool
    {
        return strlen($ruc) === 11 && is_numeric($ruc);
    }
    
    /**
     * Validar RUC peruano con algoritmo de verificación
     */
    public function validatePeruvianRuc(string $ruc): bool
    {
        $cleanRuc = $this->cleanRuc($ruc);
        
        if (!$this->isValidRuc($cleanRuc)) {
            return false;
        }
        
        // Algoritmo de validación de RUC peruano
        $multipliers = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        
        for ($i = 0; $i < 10; $i++) {
            $sum += (int)$cleanRuc[$i] * $multipliers[$i];
        }
        
        $remainder = $sum % 11;
        $checkDigit = $remainder < 2 ? $remainder : 11 - $remainder;
        
        return (int)$cleanRuc[10] === $checkDigit;
    }
    
    /**
     * Obtener sugerencias de empresas para autocompletado
     */
    public function getSuggestions(string $query, int $limit = 5): array
    {
        try {
            $suggestions = [];
            
            // Si el query parece un RUC (solo números), buscar por RUC
            if (is_numeric($query) && strlen($query) >= 8) {
                $companies = Company::where('ruc', 'like', $query . '%')
                                  ->where('activo', true)
                                  ->limit($limit)
                                  ->get();
                                  
                foreach ($companies as $company) {
                    $suggestions[] = [
                        'type' => 'ruc',
                        'value' => $company->ruc,
                        'label' => $company->ruc_formateado . ' - ' . $company->razon_social,
                        'company_data' => $this->getCompanyData($company->ruc),
                    ];
                }
            }
            
            // Buscar por razón social
            $companies = $this->searchByRazonSocial($query, $limit);
            
            foreach ($companies as $company) {
                $suggestions[] = [
                    'type' => 'razon_social',
                    'value' => $company->razon_social,
                    'label' => $company->razon_social . ' - ' . $company->ruc_formateado,
                    'company_data' => $this->getCompanyData($company->ruc),
                ];
            }
            
            // Remover duplicados y limitar
            $unique_suggestions = array_unique($suggestions, SORT_REGULAR);
            return array_slice($unique_suggestions, 0, $limit);
            
        } catch (\Exception $e) {
            Log::error('Error al obtener sugerencias: ' . $e->getMessage());
            return [];
        }
    }
}
