<?php

namespace App\Services;

use App\Models\Departamento;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LocationService
{
    /**
     * Cache duration in minutes
     */
    private const CACHE_DURATION = 1440; // 24 horas
    
    /**
     * Obtener todos los departamentos activos
     */
    public function getDepartamentos(): Collection
    {
        try {
            return Cache::remember('departamentos_activos', self::CACHE_DURATION, function () {
                return Departamento::orderBy('nombre')->get();
            });
            
        } catch (\Exception $e) {
            Log::error('Error al obtener departamentos: ' . $e->getMessage());
            return new Collection();
        }
    }
    
    /**
     * Alias para getAllDepartamentos
     */
    public function getAllDepartamentos(): Collection
    {
        return $this->getDepartamentos();
    }
    
    /**
     * Obtener provincias por departamento
     */
    public function getProvinciasByDepartamento(int $departamentoId): Collection
    {
        try {
            $cacheKey = "provincias_departamento_{$departamentoId}";
            
            return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($departamentoId) {
                return Provincia::with('departamento')
                               ->activasByDepartamento($departamentoId)
                               ->orderBy('nombre')
                               ->get();
            });
            
        } catch (\Exception $e) {
            Log::error('Error al obtener provincias por departamento: ' . $e->getMessage(), [
                'departamento_id' => $departamentoId
            ]);
            return new Collection();
        }
    }
    
    /**
     * Buscar departamento por código
     */
    public function getDepartamentoByCodigo(string $codigo): ?Departamento
    {
        try {
            return Cache::remember("departamento_codigo_{$codigo}", self::CACHE_DURATION, function () use ($codigo) {
                return Departamento::byCodigo($codigo)->activo()->first();
            });
            
        } catch (\Exception $e) {
            Log::error('Error al buscar departamento por código: ' . $e->getMessage(), [
                'codigo' => $codigo
            ]);
            return null;
        }
    }
    
    /**
     * Buscar provincia por código
     */
    public function getProvinciaByCodigo(string $codigo): ?Provincia
    {
        try {
            return Cache::remember("provincia_codigo_{$codigo}", self::CACHE_DURATION, function () use ($codigo) {
                return Provincia::with('departamento')
                               ->byCodigo($codigo)
                               ->activo()
                               ->first();
            });
            
        } catch (\Exception $e) {
            Log::error('Error al buscar provincia por código: ' . $e->getMessage(), [
                'codigo' => $codigo
            ]);
            return null;
        }
    }
    
    /**
     * Buscar ubicaciones por texto (departamentos y provincias)
     */
    public function searchLocations(string $query, int $limit = 10): array
    {
        try {
            $results = [];
            
            // Buscar departamentos
            $departamentos = Departamento::byNombre($query)
                                       ->activo()
                                       ->limit($limit)
                                       ->get();
            
            foreach ($departamentos as $dept) {
                $results[] = [
                    'type' => 'departamento',
                    'id' => $dept->id,
                    'nombre' => $dept->nombre,
                    'codigo' => $dept->codigo,
                    'label' => $dept->nombre . ' (Departamento)',
                    'provincias_count' => $dept->provincias()->count(),
                ];
            }
            
            // Buscar provincias
            $provincias = Provincia::with('departamento')
                                 ->byNombre($query)
                                 ->activo()
                                 ->limit($limit)
                                 ->get();
            
            foreach ($provincias as $prov) {
                $results[] = [
                    'type' => 'provincia',
                    'id' => $prov->id,
                    'nombre' => $prov->nombre,
                    'codigo' => $prov->codigo,
                    'departamento' => [
                        'id' => $prov->departamento->id,
                        'nombre' => $prov->departamento->nombre,
                        'codigo' => $prov->departamento->codigo,
                    ],
                    'label' => $prov->nombre . ', ' . $prov->departamento->nombre,
                ];
            }
            
            // Ordenar por relevancia (departamentos primero, luego provincias)
            usort($results, function ($a, $b) {
                if ($a['type'] !== $b['type']) {
                    return $a['type'] === 'departamento' ? -1 : 1;
                }
                return strcmp($a['nombre'], $b['nombre']);
            });
            
            return array_slice($results, 0, $limit);
            
        } catch (\Exception $e) {
            Log::error('Error al buscar ubicaciones: ' . $e->getMessage(), [
                'query' => $query
            ]);
            return [];
        }
    }
    
    /**
     * Obtener datos completos de ubicación (departamento + provincias)
     */
    public function getLocationData(int $departamentoId, ?int $provinciaId = null): array
    {
        try {
            $departamento = Departamento::with('provinciasActivas')->find($departamentoId);
            
            if (!$departamento) {
                return [];
            }
            
            $data = [
                'departamento' => [
                    'id' => $departamento->id,
                    'nombre' => $departamento->nombre,
                    'codigo' => $departamento->codigo,
                    'provincias_count' => $departamento->provinciasActivas->count(),
                ],
                'provincias' => $departamento->provinciasActivas->map(function ($provincia) {
                    return [
                        'id' => $provincia->id,
                        'nombre' => $provincia->nombre,
                        'codigo' => $provincia->codigo,
                    ];
                })->toArray(),
            ];
            
            if ($provinciaId) {
                $provincia = $departamento->provinciasActivas->find($provinciaId);
                if ($provincia) {
                    $data['provincia_seleccionada'] = [
                        'id' => $provincia->id,
                        'nombre' => $provincia->nombre,
                        'codigo' => $provincia->codigo,
                    ];
                }
            }
            
            return $data;
            
        } catch (\Exception $e) {
            Log::error('Error al obtener datos de ubicación: ' . $e->getMessage(), [
                'departamento_id' => $departamentoId,
                'provincia_id' => $provinciaId
            ]);
            return [];
        }
    }
    
    /**
     * Validar que una provincia pertenece a un departamento
     */
    public function validateProvinciaInDepartamento(int $provinciaId, int $departamentoId): bool
    {
        try {
            return Provincia::where('id', $provinciaId)
                          ->where('departamento_id', $departamentoId)
                          ->where('activo', true)
                          ->exists();
                          
        } catch (\Exception $e) {
            Log::error('Error al validar provincia en departamento: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener estadísticas de ubicaciones
     */
    public function getLocationStats(): array
    {
        try {
            return Cache::remember('location_stats', self::CACHE_DURATION, function () {
                return [
                    'departamentos_total' => Departamento::count(),
                    'departamentos_activos' => Departamento::activo()->count(),
                    'provincias_total' => Provincia::count(),
                    'provincias_activas' => Provincia::activo()->count(),
                    'empresas_por_departamento' => $this->getEmpresasPorDepartamento(),
                    'top_departamentos' => $this->getTopDepartamentos(),
                ];
            });
            
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas de ubicaciones: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtener cantidad de empresas por departamento
     */
    private function getEmpresasPorDepartamento(): array
    {
        try {
            return Departamento::withCount(['companies' => function ($query) {
                           $query->where('activo', true);
                       }])
                       ->activo()
                       ->orderBy('companies_count', 'desc')
                       ->get()
                       ->map(function ($dept) {
                           return [
                               'departamento' => $dept->nombre,
                               'empresas_count' => $dept->companies_count,
                           ];
                       })
                       ->toArray();
                       
        } catch (\Exception $e) {
            Log::error('Error al obtener empresas por departamento: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtener top departamentos con más empresas
     */
    private function getTopDepartamentos(int $limit = 5): array
    {
        try {
            return Departamento::withCount(['companies' => function ($query) {
                           $query->where('activo', true);
                       }])
                       ->activo()
                       ->having('companies_count', '>', 0)
                       ->orderBy('companies_count', 'desc')
                       ->limit($limit)
                       ->get()
                       ->map(function ($dept) {
                           return [
                               'id' => $dept->id,
                               'nombre' => $dept->nombre,
                               'codigo' => $dept->codigo,
                               'empresas_count' => $dept->companies_count,
                           ];
                       })
                       ->toArray();
                       
        } catch (\Exception $e) {
            Log::error('Error al obtener top departamentos: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Limpiar caché de ubicaciones
     */
    public function clearLocationCache(): void
    {
        try {
            Cache::forget('departamentos_activos');
            Cache::forget('location_stats');
            
            // Limpiar caché de provincias por departamento
            $departamentos = Departamento::pluck('id');
            foreach ($departamentos as $id) {
                Cache::forget("provincias_departamento_{$id}");
            }
            
            Log::info('Cache de ubicaciones limpiado');
            
        } catch (\Exception $e) {
            Log::error('Error al limpiar cache de ubicaciones: ' . $e->getMessage());
        }
    }
    
    /**
     * Formatear dirección completa
     */
    public function formatDireccionCompleta(?string $direccionCalle, ?int $provinciaId, ?int $departamentoId): string
    {
        try {
            $partes = [];
            
            if ($direccionCalle) {
                $partes[] = $direccionCalle;
            }
            
            if ($provinciaId) {
                $provincia = Provincia::find($provinciaId);
                if ($provincia) {
                    $partes[] = $provincia->nombre;
                }
            }
            
            if ($departamentoId) {
                $departamento = Departamento::find($departamentoId);
                if ($departamento) {
                    $partes[] = $departamento->nombre;
                }
            }
            
            return implode(', ', $partes);
            
        } catch (\Exception $e) {
            Log::error('Error al formatear dirección: ' . $e->getMessage());
            return '';
        }
    }
    
    /**
     * Buscar departamentos por nombre
     */
    public function searchDepartamentos(string $query): Collection
    {
        try {
            return Departamento::where('nombre', 'LIKE', "%{$query}%")
                             ->orderBy('nombre')
                             ->get();
        } catch (\Exception $e) {
            Log::error('Error al buscar departamentos: ' . $e->getMessage());
            return new Collection();
        }
    }
    
    /**
     * Buscar provincias por nombre
     */
    public function searchProvincias(string $query, ?int $departamentoId = null): Collection
    {
        try {
            $queryBuilder = Provincia::with('departamento')
                                   ->where('nombre', 'LIKE', "%{$query}%");
                                   
            if ($departamentoId) {
                $queryBuilder->where('departamento_id', $departamentoId);
            }
            
            return $queryBuilder->orderBy('nombre')->get();
        } catch (\Exception $e) {
            Log::error('Error al buscar provincias: ' . $e->getMessage());
            return new Collection();
        }
    }
    
    /**
     * Obtener departamento con sus provincias
     */
    public function getDepartamentoWithProvincias(int $id): ?Departamento
    {
        try {
            return Departamento::with('provincias')->find($id);
        } catch (\Exception $e) {
            Log::error('Error al obtener departamento con provincias: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Obtener provincia con su departamento
     */
    public function getProvinciaWithDepartamento(int $id): ?Provincia
    {
        try {
            return Provincia::with('departamento')->find($id);
        } catch (\Exception $e) {
            Log::error('Error al obtener provincia con departamento: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Validar UBIGEO
     */
    public function validateUbigeo(string $ubigeo): bool
    {
        try {
            // UBIGEO peruano tiene 6 dígitos
            if (strlen($ubigeo) !== 6 || !is_numeric($ubigeo)) {
                return false;
            }
            
            // Verificar si existe en la base de datos
            return Departamento::where('ubigeo', 'LIKE', substr($ubigeo, 0, 2) . '%')->exists() ||
                   Provincia::where('ubigeo', $ubigeo)->exists();
        } catch (\Exception $e) {
            Log::error('Error al validar UBIGEO: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener ubicación por UBIGEO
     */
    public function getLocationByUbigeo(string $ubigeo): ?array
    {
        try {
            // Buscar provincia primero
            $provincia = Provincia::with('departamento')->where('ubigeo', $ubigeo)->first();
            if ($provincia) {
                return [
                    'tipo' => 'provincia',
                    'provincia' => [
                        'id' => $provincia->id,
                        'nombre' => $provincia->nombre,
                        'codigo' => $provincia->codigo,
                        'ubigeo' => $provincia->ubigeo,
                    ],
                    'departamento' => [
                        'id' => $provincia->departamento->id,
                        'nombre' => $provincia->departamento->nombre,
                        'codigo' => $provincia->departamento->codigo,
                        'ubigeo' => $provincia->departamento->ubigeo,
                    ],
                ];
            }
            
            // Buscar departamento
            $codigoDept = substr($ubigeo, 0, 2);
            $departamento = Departamento::where('codigo', $codigoDept)->first();
            if ($departamento) {
                return [
                    'tipo' => 'departamento',
                    'departamento' => [
                        'id' => $departamento->id,
                        'nombre' => $departamento->nombre,
                        'codigo' => $departamento->codigo,
                        'ubigeo' => $departamento->ubigeo,
                    ],
                ];
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Error al obtener ubicación por UBIGEO: ' . $e->getMessage());
            return null;
        }
    }
}
