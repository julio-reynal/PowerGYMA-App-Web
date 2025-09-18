<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RiskCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RiskUpdateController extends Controller
{
    protected $riskService;

    public function __construct(RiskCalculationService $riskService)
    {
        $this->riskService = $riskService;
    }

    /**
     * Actualizar sistema de riesgo por tiempo (endpoint público para cron jobs)
     */
    public function updateByTime()
    {
        try {
            $evaluation = $this->riskService->updateRiskByTime();
            
            Log::info('Risk system updated via API endpoint', [
                'date' => $evaluation->evaluation_date,
                'risk_level' => $evaluation->risk_level,
                'triggered_at' => Carbon::now()->toIso8601String()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Sistema de riesgo actualizado exitosamente',
                'data' => [
                    'date' => $evaluation->evaluation_date->format('d/m/Y'),
                    'risk_level' => $evaluation->risk_level,
                    'start_time' => $evaluation->start_time,
                    'end_time' => $evaluation->end_time,
                    'consumption' => $evaluation->total_consumption,
                    'efficiency' => $evaluation->efficiency_percentage
                ],
                'updated_at' => Carbon::now()->toIso8601String()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error updating risk system via API: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el sistema de riesgo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar sistema de riesgo por Excel (endpoint para integración)
     */
    public function updateByExcel(Request $request)
    {
        try {
            $excelId = $request->input('excel_id');
            
            $this->riskService->updateRiskByExcelData($excelId);
            
            Log::info('Risk system updated via API endpoint with Excel data', [
                'excel_id' => $excelId,
                'triggered_at' => Carbon::now()->toIso8601String()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Sistema de riesgo actualizado con datos de Excel',
                'excel_id' => $excelId,
                'updated_at' => Carbon::now()->toIso8601String()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error updating risk system with Excel data via API: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el sistema de riesgo con datos Excel',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estado actual del sistema de riesgo
     */
    public function getStatus()
    {
        try {
            $todayEval = \App\Models\RiskEvaluation::today();
            $monthlyData = \App\Models\MonthlyRiskData::currentMonth();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'today_evaluation' => $todayEval ? [
                        'date' => $todayEval->evaluation_date->format('d/m/Y'),
                        'risk_level' => $todayEval->risk_level,
                        'start_time' => $todayEval->start_time,
                        'end_time' => $todayEval->end_time,
                        'consumption' => $todayEval->total_consumption,
                        'efficiency' => $todayEval->efficiency_percentage
                    ] : null,
                    'monthly_evaluations_count' => $monthlyData->count(),
                    'monthly_progress' => $monthlyData->count() . '/' . Carbon::now()->daysInMonth,
                    'last_update' => $todayEval?->updated_at?->toIso8601String()
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estado del sistema',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Forzar actualización manual (solo admin)
     */
    public function forceUpdate()
    {
        // Solo permitir a administradores
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        try {
            $evaluation = $this->riskService->updateRiskByTime();
            
            Log::info('Risk system force updated by admin', [
                'admin_id' => auth()->id(),
                'date' => $evaluation->evaluation_date,
                'risk_level' => $evaluation->risk_level
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Sistema de riesgo actualizado manualmente',
                'data' => [
                    'date' => $evaluation->evaluation_date->format('d/m/Y'),
                    'risk_level' => $evaluation->risk_level,
                    'consumption' => $evaluation->total_consumption,
                    'efficiency' => $evaluation->efficiency_percentage
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en actualización manual',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}