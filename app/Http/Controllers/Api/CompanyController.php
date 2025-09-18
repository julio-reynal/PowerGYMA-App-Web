<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    private CompanyService $companyService;
    
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }
    
    /**
     * Buscar empresa por RUC para autocompletado
     */
    public function getByRuc(string $ruc): JsonResponse
    {
        try {
            // Validar formato de RUC
            $validator = Validator::make(['ruc' => $ruc], [
                'ruc' => 'required|string|min:8|max:11|regex:/^[0-9]+$/',
            ], [
                'ruc.required' => 'El RUC es requerido',
                'ruc.min' => 'El RUC debe tener al menos 8 dígitos',
                'ruc.max' => 'El RUC debe tener máximo 11 dígitos',
                'ruc.regex' => 'El RUC solo debe contener números',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'RUC inválido',
                    'errors' => $validator->errors(),
                ], 400);
            }
            
            $companyData = $this->companyService->getCompanyData($ruc);
            
            if (!$companyData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Empresa no encontrada',
                    'data' => null,
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Empresa encontrada',
                'data' => $companyData,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getByRuc: ' . $e->getMessage(), [
                'ruc' => $ruc,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
        }
    }
    
    /**
     * Obtener sugerencias de empresas para autocompletado
     */
    public function getSuggestions(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'query' => 'required|string|min:2|max:100',
                'limit' => 'sometimes|integer|min:1|max:20',
            ], [
                'query.required' => 'El término de búsqueda es requerido',
                'query.min' => 'Debe ingresar al menos 2 caracteres',
                'query.max' => 'Máximo 100 caracteres',
                'limit.integer' => 'El límite debe ser un número entero',
                'limit.max' => 'Máximo 20 sugerencias',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parámetros inválidos',
                    'errors' => $validator->errors(),
                ], 400);
            }
            
            $query = $request->input('query');
            $limit = $request->input('limit', 5);
            
            $suggestions = $this->companyService->getSuggestions($query, $limit);
            
            return response()->json([
                'success' => true,
                'message' => 'Sugerencias obtenidas',
                'data' => $suggestions,
                'count' => count($suggestions),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getSuggestions: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
        }
    }
    
    /**
     * Buscar empresas por razón social
     */
    public function searchByRazonSocial(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'query' => 'required|string|min:3|max:100',
                'limit' => 'sometimes|integer|min:1|max:50',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parámetros inválidos',
                    'errors' => $validator->errors(),
                ], 400);
            }
            
            $query = $request->input('query');
            $limit = $request->input('limit', 10);
            
            $companies = $this->companyService->searchByRazonSocial($query, $limit);
            
            $results = $companies->map(function ($company) {
                return [
                    'id' => $company->id,
                    'ruc' => $company->ruc,
                    'ruc_formateado' => $company->ruc_formateado,
                    'razon_social' => $company->razon_social,
                    'telefono_fijo' => $company->telefono_fijo,
                    'direccion_completa' => $company->direccion_completa,
                    'departamento' => $company->departamento?->nombre,
                    'provincia' => $company->provincia?->nombre,
                ];
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Búsqueda completada',
                'data' => $results,
                'count' => $results->count(),
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en searchByRazonSocial: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
        }
    }
    
    /**
     * Validar RUC peruano
     */
    public function validateRuc(string $ruc): JsonResponse
    {
        try {
            $isValid = $this->companyService->validatePeruvianRuc($ruc);
            
            return response()->json([
                'success' => true,
                'message' => $isValid ? 'RUC válido' : 'RUC inválido',
                'data' => [
                    'ruc' => $ruc,
                    'is_valid' => $isValid,
                    'formatted_ruc' => $isValid ? 
                        substr($ruc, 0, 2) . '-' . substr($ruc, 2) : null,
                ],
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en validateRuc: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al validar RUC',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
        }
    }
    
    /**
     * Crear nueva empresa
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'ruc' => 'required|string|size:11|regex:/^[0-9]+$/|unique:companies,ruc',
                'razon_social' => 'required|string|max:255',
                'telefono_fijo' => 'nullable|string|max:20',
                'departamento_id' => 'nullable|exists:departamentos,id',
                'provincia_id' => 'nullable|exists:provincias,id',
                'direccion_calle' => 'nullable|string|max:500',
            ], [
                'ruc.required' => 'El RUC es requerido',
                'ruc.size' => 'El RUC debe tener exactamente 11 dígitos',
                'ruc.regex' => 'El RUC solo debe contener números',
                'ruc.unique' => 'Ya existe una empresa con este RUC',
                'razon_social.required' => 'La razón social es requerida',
                'razon_social.max' => 'La razón social no debe exceder 255 caracteres',
                'departamento_id.exists' => 'El departamento seleccionado no existe',
                'provincia_id.exists' => 'La provincia seleccionada no existe',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors(),
                ], 422);
            }
            
            // Validar RUC peruano
            if (!$this->companyService->validatePeruvianRuc($request->ruc)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El RUC ingresado no es válido según el algoritmo peruano',
                ], 422);
            }
            
            $company = $this->companyService->createOrUpdate($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Empresa creada exitosamente',
                'data' => $this->companyService->getCompanyData($company->ruc),
            ], 201);
            
        } catch (\Exception $e) {
            Log::error('Error en store: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al crear empresa',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
        }
    }
    
    /**
     * Obtener estadísticas de empresa
     */
    public function getStats(string $ruc): JsonResponse
    {
        try {
            $company = $this->companyService->findByRuc($ruc);
            
            if (!$company) {
                return response()->json([
                    'success' => false,
                    'message' => 'Empresa no encontrada',
                ], 404);
            }
            
            $stats = $this->companyService->getCompanyStats($company);
            
            return response()->json([
                'success' => true,
                'message' => 'Estadísticas obtenidas',
                'data' => [
                    'company' => [
                        'ruc' => $company->ruc,
                        'razon_social' => $company->razon_social,
                    ],
                    'stats' => $stats,
                ],
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en getStats: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas',
                'error' => config('app.debug') ? $e->getMessage() : 'Error procesando solicitud',
            ], 500);
        }
    }
}
