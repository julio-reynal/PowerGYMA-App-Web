<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    private LocationService $locationService;
    
    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }
    
    /**
     * Obtener todos los departamentos
     */
    public function getDepartamentos(): JsonResponse
    {
        try {
            $departamentos = $this->locationService->getAllDepartamentos();
            
            $formattedData = $departamentos->map(function ($departamento) {
                return [
                    'id' => $departamento->id,
                    'codigo' => $departamento->codigo,
                    'nombre' => $departamento->nombre,
                    'activo' => $departamento->activo,
                    'provincias_count' => $departamento->provincias()->count(),
                ];
            });
            
            $response = response()->json([
                'success' => true,
                'message' => 'Departamentos obtenidos exitosamente',
                'data' => $formattedData,
                'count' => $formattedData->count(),
            ]);
            
            // Agregar headers CORS
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            
            return $response;
            
        } catch (\Exception $e) {
            Log::error('Error en getDepartamentos: ' . $e->getMessage());
            
            $response = response()->json([
                'success' => false,
                'message' => 'Error al obtener departamentos',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
            
            // Agregar headers CORS también en caso de error
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            
            return $response;
        }
    }
    
    /**
     * Obtener provincias por departamento
     */
    public function getProvinciasByDepartamento(int $departamentoId): JsonResponse
    {
        try {
            $provincias = $this->locationService->getProvinciasByDepartamento($departamentoId);
            
            if ($provincias->isEmpty()) {
                $response = response()->json([
                    'success' => false,
                    'message' => 'No se encontraron provincias para este departamento',
                    'data' => [],
                    'count' => 0,
                ], 404);
                
                // Agregar headers CORS
                $response->header('Access-Control-Allow-Origin', '*');
                $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
                $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
                
                return $response;
            }
            
            $formattedData = $provincias->map(function ($provincia) {
                return [
                    'id' => $provincia->id,
                    'codigo' => $provincia->codigo,
                    'nombre' => $provincia->nombre,
                    'activo' => $provincia->activo,
                    'departamento' => [
                        'id' => $provincia->departamento->id,
                        'nombre' => $provincia->departamento->nombre,
                        'codigo' => $provincia->departamento->codigo,
                    ],
                ];
            });

            $response = response()->json([
                'success' => true,
                'message' => 'Provincias obtenidas exitosamente',
                'data' => $formattedData,
                'count' => $formattedData->count(),
            ]);
            
            // Agregar headers CORS
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            
            return $response;
            
        } catch (\Exception $e) {
            Log::error('Error en getProvinciasByDepartamento: ' . $e->getMessage(), [
                'departamento_id' => $departamentoId
            ]);
            
            $response = response()->json([
                'success' => false,
                'message' => 'Error al obtener provincias',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
            
            // Agregar headers CORS también en caso de error
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
            
            return $response;
        }
    }
    
    /**
     * Buscar departamentos por nombre
     */
    public function searchDepartamentos(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'q' => 'required|string|min:2|max:50',
                'limit' => 'sometimes|integer|min:1|max:50',
            ], [
                'q.required' => 'El término de búsqueda es requerido',
                'q.min' => 'Debe ingresar al menos 2 caracteres',
                'q.max' => 'Máximo 50 caracteres',
                'limit.integer' => 'El límite debe ser un número entero',
                'limit.max' => 'Máximo 50 resultados',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parámetros inválidos',
                    'errors' => $validator->errors(),
                ], 400);
            }
            
            $query = $request->input('q');
            $limit = $request->input('limit', 10);
            $departamentos = $this->locationService->searchDepartamentos($query);
            
            // Aplicar límite
            $departamentos = $departamentos->take($limit);
            
            $formattedData = $departamentos->map(function ($departamento) {
                return [
                    'id' => $departamento->id,
                    'codigo' => $departamento->codigo,
                    'nombre' => $departamento->nombre,
                    'ubigeo' => $departamento->ubigeo,
                    'provincias_count' => $departamento->provincias()->count(),
                ];
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Búsqueda completada',
                'data' => $formattedData,
                'count' => $formattedData->count(),
                'query' => $query,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en searchDepartamentos: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
        }
    }
    
    /**
     * Buscar provincias por nombre
     */
    public function searchProvincias(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'q' => 'required|string|min:2|max:50',
                'departamento_id' => 'sometimes|integer|exists:departamentos,id',
                'limit' => 'sometimes|integer|min:1|max:50',
            ], [
                'q.required' => 'El término de búsqueda es requerido',
                'q.min' => 'Debe ingresar al menos 2 caracteres',
                'q.max' => 'Máximo 50 caracteres',
                'departamento_id.exists' => 'El departamento seleccionado no existe',
                'limit.integer' => 'El límite debe ser un número entero',
                'limit.max' => 'Máximo 50 resultados',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parámetros inválidos',
                    'errors' => $validator->errors(),
                ], 400);
            }
            
            $query = $request->input('q');
            $departamentoId = $request->input('departamento_id');
            $limit = $request->input('limit', 10);
            
            $provincias = $this->locationService->searchProvincias($query, $departamentoId);
            
            // Aplicar límite
            $provincias = $provincias->take($limit);
            
            $formattedData = $provincias->map(function ($provincia) {
                return [
                    'id' => $provincia->id,
                    'codigo' => $provincia->codigo,
                    'nombre' => $provincia->nombre,
                    'ubigeo' => $provincia->ubigeo,
                    'departamento' => [
                        'id' => $provincia->departamento->id,
                        'nombre' => $provincia->departamento->nombre,
                        'codigo' => $provincia->departamento->codigo,
                    ],
                ];
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Búsqueda completada',
                'data' => $formattedData,
                'count' => $formattedData->count(),
                'query' => $query,
                'departamento_id' => $departamentoId,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en searchProvincias: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
        }
    }
    
    /**
     * Obtener información completa de un departamento
     */
    public function getDepartamento(int $id): JsonResponse
    {
        try {
            $departamento = $this->locationService->getDepartamentoWithProvincias($id);
            
            if (!$departamento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Departamento no encontrado',
                ], 404);
            }
            
            $formattedData = [
                'id' => $departamento->id,
                'codigo' => $departamento->codigo,
                'nombre' => $departamento->nombre,
                'ubigeo' => $departamento->ubigeo,
                'provincias' => $departamento->provincias->map(function ($provincia) {
                    return [
                        'id' => $provincia->id,
                        'codigo' => $provincia->codigo,
                        'nombre' => $provincia->nombre,
                        'ubigeo' => $provincia->ubigeo,
                    ];
                }),
            ];
            
            return response()->json([
                'success' => true,
                'message' => 'Departamento obtenido exitosamente',
                'data' => $formattedData,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getDepartamento: ' . $e->getMessage(), [
                'departamento_id' => $id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener departamento',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
        }
    }
    
    /**
     * Obtener información de una provincia específica
     */
    public function getProvincia(int $id): JsonResponse
    {
        try {
            $provincia = $this->locationService->getProvinciaWithDepartamento($id);
            
            if (!$provincia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Provincia no encontrada',
                ], 404);
            }
            
            $formattedData = [
                'id' => $provincia->id,
                'codigo' => $provincia->codigo,
                'nombre' => $provincia->nombre,
                'ubigeo' => $provincia->ubigeo,
                'departamento' => [
                    'id' => $provincia->departamento->id,
                    'codigo' => $provincia->departamento->codigo,
                    'nombre' => $provincia->departamento->nombre,
                    'ubigeo' => $provincia->departamento->ubigeo,
                ],
            ];
            
            return response()->json([
                'success' => true,
                'message' => 'Provincia obtenida exitosamente',
                'data' => $formattedData,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getProvincia: ' . $e->getMessage(), [
                'provincia_id' => $id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener provincia',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
        }
    }
    
    /**
     * Obtener estadísticas de ubicaciones
     */
    public function getLocationStats(): JsonResponse
    {
        try {
            $stats = $this->locationService->getLocationStats();
            
            return response()->json([
                'success' => true,
                'message' => 'Estadísticas obtenidas exitosamente',
                'data' => $stats,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getLocationStats: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
        }
    }
    
    /**
     * Validar UBIGEO
     */
    public function validateUbigeo(string $ubigeo): JsonResponse
    {
        try {
            $isValid = $this->locationService->validateUbigeo($ubigeo);
            
            $locationData = null;
            if ($isValid) {
                $locationData = $this->locationService->getLocationByUbigeo($ubigeo);
            }
            
            return response()->json([
                'success' => true,
                'message' => $isValid ? 'UBIGEO válido' : 'UBIGEO inválido',
                'data' => [
                    'ubigeo' => $ubigeo,
                    'is_valid' => $isValid,
                    'location' => $locationData,
                ],
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en validateUbigeo: ' . $e->getMessage(), [
                'ubigeo' => $ubigeo
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al validar UBIGEO',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
        }
    }
}
