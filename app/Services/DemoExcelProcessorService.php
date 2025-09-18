<?php

namespace App\Services;

use App\Models\RiskEvaluation;
use App\Models\MonthlyRiskData;
use App\Models\ExcelUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DemoExcelProcessorService extends ExcelProcessorService
{
    /**
     * Procesar archivo Excel específicamente para el modo demo
     * Las fechas se convertirán automáticamente al mes anterior
     */
    public function processDemoFile($filePath, $uploadId = null, $csvYear = null)
    {
        try {
            Log::info("Iniciando procesamiento de archivo Excel para modo DEMO", [
                'filePath' => $filePath,
                'uploadId' => $uploadId,
                'csvYear' => $csvYear
            ]);

            // Usar el año actual para procesar las fechas del Excel
            $this->csvYear = $csvYear ? (int) $csvYear : now()->year;
            
            // Leer el archivo CSV
            $data = $this->readCsvFile($filePath);
            
            // Detectar el formato del archivo
            if ($this->isTemplateFormat($data)) {
                $result = $this->extractRiskTemplateDataForDemo($data);
            } else {
                $result = $this->extractLegacyFormatDataForDemo($data);
            }

            $processedCount = 0;

            // Procesar evaluación diaria si existe (para el mes anterior)
            if ($result['daily_evaluation']) {
                $this->processDailyEvaluationForDemo($result['daily_evaluation']);
                $processedCount++;
            }

            // Procesar datos mensuales (para el mes anterior)
            foreach ($result['monthly_data'] as $monthlyData) {
                $this->processMonthlyDataForDemo($monthlyData);
                $processedCount++;
            }

            // Registrar en log de uploads
            if ($uploadId) {
                $upload = ExcelUpload::find($uploadId);
                if (isset($upload)) {
                    $upload->update([
                        'status' => 'completed',
                        'records_processed' => $processedCount,
                        'processed_at' => now(),
                        'processing_summary' => array_merge(
                            $upload->processing_summary ?? [],
                            [
                                'demo_mode' => true,
                                'converted_to_previous_month' => true,
                                'original_year' => $this->csvYear,
                                'demo_year' => now()->subMonth()->year,
                                'demo_month' => now()->subMonth()->month
                            ]
                        )
                    ]);
                }
            }

            Log::info("Archivo Excel procesado exitosamente para modo DEMO", [
                'processedCount' => $processedCount,
                'uploadId' => $uploadId
            ]);

            return [
                'success' => true,
                'message' => "Archivo procesado exitosamente para DEMO. {$processedCount} registros procesados con fechas del mes anterior.",
                'upload_id' => $uploadId,
                'summary' => [
                    'daily_evaluations' => $result['daily_evaluation'] ? 1 : 0,
                    'monthly_data' => count($result['monthly_data']),
                    'demo_mode' => true,
                    'converted_to_previous_month' => true,
                    'errors' => []
                ]
            ];

        } catch (\Exception $e) {
            $errorMessage = "Error procesando archivo para modo DEMO: " . $e->getMessage();
            
            Log::error('Error procesando archivo para demo: ' . $errorMessage, [
                'file_path' => $filePath,
                'upload_id' => $uploadId,
                'original_error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($uploadId) {
                $upload = ExcelUpload::find($uploadId);
                if (isset($upload)) {
                    $upload->update([
                        'status' => 'failed',
                        'error_message' => $errorMessage
                    ]);
                }
            }

            throw new \Exception($errorMessage);
        }
    }

    /**
     * Extraer datos del template adaptados para demo (mes anterior)
     */
    private function extractRiskTemplateDataForDemo($data)
    {
        // Limpiar y validar datos antes de procesar
        $data = $this->cleanCsvData($data);
        
        // Extraer metadatos de las primeras 4 filas
        $metadata = [];
        for ($i = 0; $i < 4; $i++) {
            if (isset($data[$i]) && count($data[$i]) >= 2) {
                $key = trim($data[$i][0]);
                $value = trim($data[$i][1]);
                $metadata[$key] = $value;
            }
        }

        if (!isset($metadata['FECHA']) || !isset($metadata['RIESGO'])) {
            throw new \Exception('Metadatos requeridos faltantes (FECHA, RIESGO)');
        }

        // Extraer evaluación diaria de los metadatos - CONVERTIR AL MES ANTERIOR
        $dailyEvaluation = null;
        $riesgoMeta = $metadata['RIESGO'];
        
        // Parsear fecha original y convertir al mes anterior
        $fechaOriginal = $this->parsearFechaCorta($metadata['FECHA'], $this->csvYear);
        $fechaDemo = $this->convertToLastMonth($fechaOriginal);
        
        // Si el riesgo diario viene como 'null' o vacío, no crear evaluación diaria
        if (!empty($riesgoMeta) && strtolower(trim($riesgoMeta)) !== 'null') {
            $dailyEvaluation = [
                'fecha' => $fechaDemo,
                'fecha_original' => $fechaOriginal,
                'nivel_riesgo' => $riesgoMeta
            ];

            // Agregar campos opcionales
            if (isset($metadata['HORA INICIO'])) {
                $dailyEvaluation['hora_inicio'] = $metadata['HORA INICIO'];
            }
            if (isset($metadata['HORA FIN'])) {
                $dailyEvaluation['hora_fin'] = $metadata['HORA FIN'];
            }

            // Calcular serie horaria si hay hora inicio/fin
            if (isset($dailyEvaluation['hora_inicio']) && isset($dailyEvaluation['hora_fin'])) {
                $dailyEvaluation['hourly_data'] = $this->buildHourlySeries($dailyEvaluation['hora_inicio'], $dailyEvaluation['hora_fin']);
            }
        }

        // Procesar datos mensuales (a partir de la fila 5) - CONVERTIR AL MES ANTERIOR
        $monthlyData = [];
        for ($i = 5; $i < count($data); $i++) {
            $row = $data[$i];
            if (empty($row) || empty($row[0]) || count($row) < 2) continue;

            try {
                $fechaCorta = trim($row[0]);
                $nivelRiesgo = trim($row[1]);
                
                // Verificar si los datos están vacíos o son nulos
                if (empty($fechaCorta)) continue;
                
                // Normalizar fecha original con el año seleccionado
                $fechaOriginal = $this->parsearFechaCorta($fechaCorta, $this->csvYear);
                
                // Convertir al mes anterior para el demo
                $fechaDemo = $this->convertToLastMonth($fechaOriginal);

                // Detectar valores nulos explícitos (como "null", "NULL", vacío) -> pendiente
                if ($nivelRiesgo === '' || strtolower($nivelRiesgo) === 'null') {
                    $monthlyData[] = [
                        'fecha' => $fechaDemo,
                        'fecha_original' => $fechaOriginal,
                        'nivel_riesgo' => null,
                        'status' => 'pendiente',
                        'observaciones' => 'Pendiente (Demo - Mes Anterior)'
                    ];
                    continue;
                }

                $monthlyData[] = [
                    'fecha' => $fechaDemo,
                    'fecha_original' => $fechaOriginal,
                    'nivel_riesgo' => $nivelRiesgo,
                    'observaciones' => isset($row[2]) ? trim($row[2]) . ' (Demo - Mes Anterior)' : 'Demo - Mes Anterior'
                ];
            } catch (\Exception $e) {
                Log::warning("Error procesando fila {$i} para demo: " . $e->getMessage());
                continue;
            }
        }

        Log::info("Datos extraídos para demo", [
            'daily_evaluation' => $dailyEvaluation ? true : false,
            'monthly_data_count' => count($monthlyData),
            'sample_dates' => array_slice(array_column($monthlyData, 'fecha'), 0, 5)
        ]);

        return [
            'daily_evaluation' => $dailyEvaluation,
            'monthly_data' => $monthlyData
        ];
    }

    /**
     * Extraer datos del formato legacy adaptados para demo (mes anterior)
     */
    private function extractLegacyFormatDataForDemo($data)
    {
        $result = parent::extractLegacyFormatData($data);
        
        // Convertir todas las fechas al mes anterior
        if ($result['daily_evaluation']) {
            $fechaOriginal = $result['daily_evaluation']['fecha'];
            $result['daily_evaluation']['fecha'] = $this->convertToLastMonth($fechaOriginal);
            $result['daily_evaluation']['fecha_original'] = $fechaOriginal;
        }

        foreach ($result['monthly_data'] as &$monthlyData) {
            $fechaOriginal = $monthlyData['fecha'];
            $monthlyData['fecha'] = $this->convertToLastMonth($fechaOriginal);
            $monthlyData['fecha_original'] = $fechaOriginal;
            // Agregar marca de demo a las observaciones
            $monthlyData['observaciones'] = ($monthlyData['observaciones'] ?? '') . ' (Demo - Mes Anterior)';
        }

        return $result;
    }

    /**
     * Convertir una fecha al mes anterior manteniendo el día
     */
    private function convertToLastMonth($fecha)
    {
        try {
            $originalDate = Carbon::parse($fecha);
            $lastMonth = Carbon::now()->subMonth();
            
            // Mantener el día, pero usar año y mes del mes anterior
            $demoDate = Carbon::create(
                $lastMonth->year, 
                $lastMonth->month, 
                $originalDate->day,
                $originalDate->hour ?? 0,
                $originalDate->minute ?? 0,
                $originalDate->second ?? 0
            );

            // Si el día no existe en el mes anterior (ej: 31 de marzo -> febrero), usar el último día del mes
            if ($demoDate->month != $lastMonth->month) {
                $demoDate = Carbon::create($lastMonth->year, $lastMonth->month, 1)->endOfMonth();
            }

            return $demoDate->format('Y-m-d');
        } catch (\Exception $e) {
            Log::error("Error convirtiendo fecha al mes anterior: " . $e->getMessage(), [
                'fecha_original' => $fecha
            ]);
            // En caso de error, usar el primer día del mes anterior
            return Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        }
    }

    /**
     * Procesar evaluación diaria para demo (con fechas del mes anterior)
     */
    private function processDailyEvaluationForDemo($data)
    {
        if (!$data) { return; }
        
        Log::info("Procesando evaluación diaria para demo", [
            'fecha_demo' => $data['fecha'],
            'fecha_original' => $data['fecha_original'] ?? 'N/A',
            'nivel_riesgo' => $data['nivel_riesgo']
        ]);
        
        // Buscar si ya existe una evaluación para esta fecha del mes anterior
        $existing = RiskEvaluation::where('evaluation_date', $data['fecha'])->first();
        
        if ($existing) {
            // Actualizar existente
            $updateData = [
                'risk_level' => $data['nivel_riesgo'],
                'updated_at' => now(),
                'notes' => ($existing->notes ?? '') . ' [Actualizado desde Demo - ' . now()->format('Y-m-d H:i') . ']'
            ];

            // Agregar campos opcionales si existen
            if (isset($data['hora_inicio'])) {
                $updateData['start_time'] = $data['hora_inicio'];
            }
            if (isset($data['hora_fin'])) {
                $updateData['end_time'] = $data['hora_fin'];
            }
            if (isset($data['observaciones'])) {
                $updateData['notes'] = $data['observaciones'];
            }

            // Serie horaria
            if (isset($data['hourly_data']) && is_array($data['hourly_data'])) {
                $updateData['hourly_data'] = $data['hourly_data'];
            }

            $existing->update($updateData);
            Log::info("Evaluación diaria actualizada para demo", ['id' => $existing->id]);
        } else {
            // Crear nueva evaluación
            $createData = [
                'evaluation_date' => $data['fecha'],
                'risk_level' => $data['nivel_riesgo'],
                'notes' => 'Datos de Demo - Mes Anterior [' . now()->format('Y-m-d H:i') . ']',
                'created_at' => now(),
                'updated_at' => now()
            ];

            // Agregar campos opcionales
            if (isset($data['hora_inicio'])) {
                $createData['start_time'] = $data['hora_inicio'];
            }
            if (isset($data['hora_fin'])) {
                $createData['end_time'] = $data['hora_fin'];
            }
            if (isset($data['observaciones'])) {
                $createData['notes'] = $data['observaciones'];
            }

            // Serie horaria
            if (isset($data['hourly_data']) && is_array($data['hourly_data'])) {
                $createData['hourly_data'] = $data['hourly_data'];
            }

            $created = RiskEvaluation::create($createData);
            Log::info("Nueva evaluación diaria creada para demo", ['id' => $created->id]);
        }
    }

    /**
     * Procesar datos mensuales para demo (con fechas del mes anterior)
     */
    private function processMonthlyDataForDemo($data)
    {
        // Parsear fecha a componentes año/mes/día para ajustarse al esquema de la tabla
        $date = Carbon::parse($data['fecha']);

        Log::info("Procesando dato mensual para demo", [
            'fecha_demo' => $data['fecha'],
            'fecha_original' => $data['fecha_original'] ?? 'N/A',
            'nivel_riesgo' => $data['nivel_riesgo'],
            'year' => $date->year,
            'month' => $date->month,
            'day' => $date->day
        ]);

        // Validar el nivel de riesgo
        $validRiskLevels = ['Muy Bajo', 'Bajo', 'Moderado', 'Alto', 'Crítico', 'No procede'];
        $riskLevel = $data['nivel_riesgo'];
        $inputStatus = $data['status'] ?? null;
        
        // Resolver estado y nivel de riesgo
        if ($inputStatus === 'pendiente') {
            // Se almacena como pendiente con nivel nulo
            $status = 'pendiente';
            $riskLevelDb = null;
        } else {
            // Si el nivel de riesgo no es válido, usar "No procede" como default
            $riskLevelDb = in_array($riskLevel, $validRiskLevels) ? $riskLevel : 'No procede';
            $status = ($riskLevelDb !== 'No procede') ? 'evaluado' : 'no_procede';
        }

        // Verificar si ya existe por año/mes/día (índice único)
        $existing = MonthlyRiskData::where('year', $date->year)
            ->where('month', $date->month)
            ->where('day', $date->day)
            ->first();
        
        if ($existing) {
            // Actualizar existente
            $updateData = [
                'risk_level' => $riskLevelDb,
                'updated_at' => now(),
                'status' => $status,
            ];

            $existing->update($updateData);
            Log::info("Dato mensual actualizado para demo", ['id' => $existing->id]);
        } else {
            // Crear nuevo registro
            $createData = [
                'year' => $date->year,
                'month' => $date->month,
                'day' => $date->day,
                'risk_level' => $riskLevelDb,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $created = MonthlyRiskData::create($createData);
            Log::info("Nuevo dato mensual creado para demo", ['id' => $created->id]);
        }
    }
}