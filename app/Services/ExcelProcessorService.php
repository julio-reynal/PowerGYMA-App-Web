<?php

namespace App\Services;

use App\Models\RiskEvaluation;
use App\Models\MonthlyRiskData;
use App\Models\ExcelUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ExcelProcessorService
{
    /** @var int|null */
    private $csvYear = null;

    public function processFile($filePath, $uploadId = null, $csvYear = null)
    {
        try {
            if (!file_exists($filePath)) {
                throw new \Exception('El archivo no existe: ' . $filePath);
            }

            if (!is_readable($filePath)) {
                throw new \Exception('El archivo no es legible: ' . $filePath);
            }

            // Configurar año para fechas cortas del CSV (DD-mmm)
            $this->csvYear = $csvYear ? (int) $csvYear : now()->year;

            $data = $this->readCsvFile($filePath);
            
            // Detectar el formato del archivo
            if ($this->isTemplateFormat($data)) {
                $result = $this->extractRiskTemplateData($data);
            } else {
                $result = $this->extractLegacyFormatData($data);
            }

            $processedCount = 0;

            // Procesar evaluación diaria si existe
            if ($result['daily_evaluation']) {
                $this->processDailyEvaluation($result['daily_evaluation']);
                $processedCount++;
            }

            // Procesar datos mensuales
            foreach ($result['monthly_data'] as $monthlyData) {
                $this->processMonthlyData($monthlyData);
                $processedCount++;
            }

            // Registrar en log de uploads
            if ($uploadId) {
                $upload = ExcelUpload::find($uploadId);
                if (isset($upload)) {
                    $upload->update([
                        'status' => 'completed',
                        'records_processed' => $processedCount,
                        'processed_at' => now()
                    ]);
                }
            }

            return [
                'success' => true,
                'message' => "Archivo procesado exitosamente. {$processedCount} registros procesados.",
                'upload_id' => $uploadId,
                'summary' => [
                    'daily_evaluations' => $result['daily_evaluation'] ? 1 : 0,
                    'monthly_data' => count($result['monthly_data']),
                    'errors' => []
                ]
            ];

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            
            // Mejorar mensaje de error para problemas de codificación
            if (strpos($errorMessage, 'UTF-8') !== false || strpos($errorMessage, 'encoding') !== false) {
                $errorMessage = "Error de codificación del archivo: El archivo CSV contiene caracteres especiales o no está codificado en UTF-8. " . 
                               "Intenta guardar el archivo como 'CSV UTF-8' desde Excel o utiliza un editor que soporte UTF-8.";
            } elseif (strpos($errorMessage, 'Mes no reconocido') !== false) {
                $errorMessage = $errorMessage . " Verifica que las fechas estén en formato DD-MMM (ejemplo: 1-sept, 25-ago).";
            }
            
            Log::error('Error procesando archivo: ' . $errorMessage, [
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

    // Método alias para compatibilidad con el ExcelController existente
    public function processExcelFile($filePath, $uploadId = null, $csvYear = null)
    {
        return $this->processFile($filePath, $uploadId, $csvYear);
    }

    private function readCsvFile($filePath)
    {
        $data = [];
        
        if (!file_exists($filePath)) {
            throw new \Exception('Archivo no encontrado: ' . $filePath);
        }

        if (!is_readable($filePath)) {
            throw new \Exception('Archivo no es legible: ' . $filePath);
        }

        // Leer el contenido completo del archivo para detectar codificación
        $content = file_get_contents($filePath);
        if ($content === false) {
            throw new \Exception('No se pudo leer el contenido del archivo CSV');
        }

        // Detectar y convertir codificación
        $encoding = mb_detect_encoding($content, ['UTF-8', 'ISO-8859-1', 'Windows-1252', 'ASCII'], true);
        
        if ($encoding === false) {
            // Si no se puede detectar, intentar con UTF-8
            $encoding = 'UTF-8';
        }

        // Convertir a UTF-8 si es necesario
        if ($encoding !== 'UTF-8') {
            $content = mb_convert_encoding($content, 'UTF-8', $encoding);
            Log::info("Archivo CSV convertido de {$encoding} a UTF-8");
        }

        // Limpiar caracteres BOM si existen
        $content = str_replace("\xEF\xBB\xBF", '', $content);

        // Crear un archivo temporal con el contenido limpio
        $tempFile = tempnam(sys_get_temp_dir(), 'csv_clean_');
        file_put_contents($tempFile, $content);

        try {
            $handle = fopen($tempFile, 'r');
            if ($handle === FALSE) {
                throw new \Exception('No se pudo abrir el archivo CSV temporal');
            }

            // Detectar separador automáticamente
            $firstLine = fgets($handle);
            rewind($handle);
            
            $delimiter = ',';
            if (substr_count($firstLine, ';') > substr_count($firstLine, ',')) {
                $delimiter = ';';
            }

            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                // Limpiar cada celda de caracteres extraños
                $cleanRow = [];
                foreach ($row as $cell) {
                    // Eliminar caracteres de control y normalizar
                    $cleanCell = preg_replace('/[\x00-\x1F\x7F]/', '', $cell);
                    $cleanCell = trim($cleanCell);
                    $cleanRow[] = $cleanCell;
                }
                $data[] = $cleanRow;
            }
            fclose($handle);

        } finally {
            // Limpiar archivo temporal
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }

        if (empty($data)) {
            throw new \Exception('El archivo CSV está vacío o no se pudo leer correctamente');
        }

        Log::info("CSV leído exitosamente. Filas: " . count($data) . ", Codificación detectada: {$encoding}");

        return $data;
    }

    private function isTemplateFormat($data)
    {
        if (empty($data)) {
            return false;
        }

        // Verificar si las primeras filas contienen metadatos en formato CLAVE,VALOR
        if (count($data) >= 4 && 
            isset($data[0][0]) && strpos($data[0][0], 'FECHA') === 0 &&
            isset($data[1][0]) && strpos($data[1][0], 'RIESGO') === 0) {
            return true;
        }

        return false;
    }

    private function extractRiskTemplateData($data)
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

        // Extraer evaluación diaria de los metadatos
        $dailyEvaluation = null;
        $riesgoMeta = $metadata['RIESGO'];
        $fechaMeta = $this->parsearFechaCorta($metadata['FECHA'], $this->csvYear);
        // Si el riesgo diario viene como 'null' o vacío, no crear evaluación diaria
        if (!empty($riesgoMeta) && strtolower(trim($riesgoMeta)) !== 'null') {
            $dailyEvaluation = [
                'fecha' => $fechaMeta,
                'nivel_riesgo' => $riesgoMeta
            ];
        }

        // Agregar campos opcionales
        if (isset($metadata['HORA INICIO'])) {
            $dailyEvaluation['hora_inicio'] = $metadata['HORA INICIO'];
        }
        if (isset($metadata['HORA FIN'])) {
            $dailyEvaluation['hora_fin'] = $metadata['HORA FIN'];
        }

        // Calcular serie horaria si hay hora inicio/fin
        if ($dailyEvaluation && isset($dailyEvaluation['hora_inicio']) && isset($dailyEvaluation['hora_fin'])) {
            $dailyEvaluation['hourly_data'] = $this->buildHourlySeries($dailyEvaluation['hora_inicio'], $dailyEvaluation['hora_fin']);
        }

    // Procesar datos mensuales (a partir de la fila 5)
    // Índices esperados:
    // 0: FECHA, 1: RIESGO, 2: HORA INICIO, 3: HORA FIN, 4: (posible fila en blanco), 5+: datos
    $monthlyData = [];
    for ($i = 5; $i < count($data); $i++) {
            $row = $data[$i];
            if (empty($row) || empty($row[0]) || count($row) < 2) continue;

            try {
                $fechaCorta = trim($row[0]);
                $nivelRiesgo = trim($row[1]);
                
                // Verificar si los datos están vacíos o son nulos
                if (empty($fechaCorta)) continue;
                
                // Normalizar fecha con el año seleccionado
                $fechaString = $this->parsearFechaCorta($fechaCorta, $this->csvYear);

                // Detectar valores nulos explícitos (como "null", "NULL", vacío) -> pendiente
                if ($nivelRiesgo === '' || strtolower($nivelRiesgo) === 'null') {
                    $monthlyData[] = [
                        'fecha' => $fechaString,
                        'nivel_riesgo' => null,
                        'status' => 'pendiente',
                        'observaciones' => 'Pendiente'
                    ];
                    continue;
                }

                $monthlyData[] = [
                    'fecha' => $fechaString,
                    'nivel_riesgo' => $nivelRiesgo,
                    'observaciones' => isset($row[2]) ? trim($row[2]) : ''
                ];
            } catch (\Exception $e) {
                Log::warning("Error procesando fila {$i}: " . $e->getMessage());
                continue;
            }
        }

        return [
            'daily_evaluation' => $dailyEvaluation,
            'monthly_data' => $monthlyData
        ];
    }

    private function buildHourlySeries(string $horaInicio, string $horaFin): array
    {
        // Serie 00..23 con porcentajes (aprox) para representar evolución
        // Esquema: antes del inicio -> bajo (20), inicio -> medio (50),
        // tramo pico (inicio+1 .. fin+1) -> alto (80), salida -> medio (50), resto -> bajo (20)
        $low = 20; $mid = 50; $high = 80;
        $series = [];

        // Normalizar horas a enteros 0..23
        $startH = (int) \Carbon\Carbon::parse($horaInicio)->format('H');
        $endH = (int) \Carbon\Carbon::parse($horaFin)->format('H');

        for ($h = 0; $h <= 23; $h++) {
            if ($h < $startH) {
                $series[sprintf('%02d:00', $h)] = $low;
            } elseif ($h == $startH) {
                $series[sprintf('%02d:00', $h)] = $mid;
            } elseif ($h >= $startH + 1 && $h <= $endH + 1) {
                $series[sprintf('%02d:00', $h)] = $high;
            } elseif ($h == $endH + 2) {
                $series[sprintf('%02d:00', $h)] = $mid;
            } else {
                $series[sprintf('%02d:00', $h)] = $low;
            }
        }

        return $series; // p.ej. {"00:00":20, "01:00":20, ..., "20:00":80}
    }

    private function parsearFechaCorta($fechaCorta, $year = null)
    {
        // Convertir formato "25-ago" o "1-ago" a fecha completa
        $meses = [
            // Enero
            'ene' => '01', 'enero' => '01', 'jan' => '01',
            // Febrero  
            'feb' => '02', 'febrero' => '02', 'febr' => '02',
            // Marzo
            'mar' => '03', 'marzo' => '03',
            // Abril
            'abr' => '04', 'abril' => '04', 'apr' => '04',
            // Mayo
            'may' => '05', 'mayo' => '05',
            // Junio
            'jun' => '06', 'junio' => '06', 'june' => '06',
            // Julio
            'jul' => '07', 'julio' => '07', 'july' => '07',
            // Agosto
            'ago' => '08', 'agosto' => '08', 'aug' => '08',
            // Septiembre - AQUÍ ESTÁ EL PROBLEMA PRINCIPAL
            'sep' => '09', 'sept' => '09', 'septiembre' => '09', 'september' => '09',
            // Octubre
            'oct' => '10', 'octubre' => '10', 'october' => '10',
            // Noviembre
            'nov' => '11', 'noviembre' => '11', 'november' => '11',
            // Diciembre
            'dic' => '12', 'diciembre' => '12', 'dec' => '12', 'december' => '12'
        ];

        $partes = explode('-', strtolower(trim($fechaCorta)));
        if (count($partes) !== 2) {
            throw new \Exception("Formato de fecha inválido: {$fechaCorta}. Esperado: DD-MMM (ejemplo: 1-sept, 25-ago)");
        }

        $dia = str_pad($partes[0], 2, '0', STR_PAD_LEFT);
        $mesAbrev = trim($partes[1]);

        if (!isset($meses[$mesAbrev])) {
            $mesesDisponibles = array_keys($meses);
            $sugerencias = [];
            
            // Buscar sugerencias similares
            foreach (['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'sept', 'oct', 'nov', 'dic'] as $mes) {
                if (stripos($mes, $mesAbrev) !== false || stripos($mesAbrev, $mes) !== false) {
                    $sugerencias[] = $mes;
                }
            }
            
            $mensajeError = "Mes no reconocido: '{$mesAbrev}'. ";
            if (!empty($sugerencias)) {
                $mensajeError .= "¿Quizás quisiste decir: " . implode(', ', array_slice($sugerencias, 0, 3)) . "?";
            } else {
                $mensajeError .= "Meses válidos: ene, feb, mar, abr, may, jun, jul, ago, sep, sept, oct, nov, dic";
            }
            
            throw new \Exception($mensajeError);
        }

        $mes = $meses[$mesAbrev];
        $anio = $year ? (int) $year : ($this->csvYear ?: (int) date('Y'));

        return sprintf('%04d-%s-%s', $anio, $mes, $dia);
    }

    private function extractLegacyFormatData($data)
    {
        $result = [
            'daily_evaluation' => null,
            'monthly_data' => []
        ];

        // Buscar cabeceras para identificar las secciones
        $headerRow = -1;
        
        foreach ($data as $index => $row) {
            if (empty($row)) continue;
            
            // Buscar cabecera principal
            if (in_array('Fecha', $row) && in_array('Consumo Total (kWh)', $row)) {
                $headerRow = $index;
                break;
            }
        }

        if ($headerRow === -1) {
            throw new \Exception('No se encontró la cabecera esperada en el archivo');
        }

        // Mapear columnas
        $headers = $data[$headerRow];
        $columnMap = [];
        foreach ($headers as $colIndex => $header) {
            $columnMap[trim($header)] = $colIndex;
        }

        // Validar columnas requeridas
        $requiredColumns = [
            'Fecha', 'Consumo Total (kWh)', 'Demanda Máxima (kW)', 
            'Factor de Potencia', 'Costo Total ($)', 'Eficiencia (%)',
            'Nivel de Riesgo', 'Observaciones'
        ];

        foreach ($requiredColumns as $required) {
            if (!isset($columnMap[$required])) {
                throw new \Exception("Columna requerida faltante: {$required}");
            }
        }

        // Procesar filas de datos
        for ($i = $headerRow + 1; $i < count($data); $i++) {
            $row = $data[$i];
            
            if (empty($row) || empty($row[0])) continue;

            try {
                $processedRow = $this->processDataRow($row, $columnMap);
                
                if ($processedRow) {
                    // Determinar si es dato diario o mensual basado en la fecha
                    $date = Carbon::parse($processedRow['fecha']);
                    
                    if ($date->day === 1) {
                        // Primer día del mes - considerarlo como dato mensual
                        $result['monthly_data'][] = $processedRow;
                    } else {
                        // Dato diario
                        if (!$result['daily_evaluation']) {
                            $result['daily_evaluation'] = $processedRow;
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Error procesando fila {$i}: " . $e->getMessage());
                continue;
            }
        }

        return $result;
    }

    private function processDataRow($row, $columnMap)
    {
        try {
            $fecha = trim($row[$columnMap['Fecha']]);
            if (empty($fecha)) return null;

            // Validar y parsear fecha
            $parsedDate = Carbon::parse($fecha);
            
            return [
                'fecha' => $parsedDate->format('Y-m-d'),
                'consumo_total' => (float) $row[$columnMap['Consumo Total (kWh)']],
                'demanda_maxima' => (float) $row[$columnMap['Demanda Máxima (kW)']],
                'factor_potencia' => (float) $row[$columnMap['Factor de Potencia']],
                'costo_total' => (float) $row[$columnMap['Costo Total ($)']],
                'eficiencia' => (float) $row[$columnMap['Eficiencia (%)']],
                'nivel_riesgo' => trim($row[$columnMap['Nivel de Riesgo']]),
                'observaciones' => trim($row[$columnMap['Observaciones']] ?? '')
            ];
        } catch (\Exception $e) {
            throw new \Exception("Error procesando datos de la fila: " . $e->getMessage());
        }
    }

    private function processDailyEvaluation($data)
    {
        if (!$data) { return; }
        // Buscar si ya existe una evaluación para esta fecha
        $existing = RiskEvaluation::where('evaluation_date', $data['fecha'])->first();
        
        if ($existing) {
            // Actualizar existente
            $updateData = [
                'risk_level' => $data['nivel_riesgo'],
                'updated_at' => now()
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
            
            // Campos de energía (formato legacy)
            if (isset($data['consumo_total'])) {
                $updateData['total_consumption'] = $data['consumo_total'];
            }
            if (isset($data['demanda_maxima'])) {
                $updateData['max_demand'] = $data['demanda_maxima'];
            }
            if (isset($data['factor_potencia'])) {
                $updateData['power_factor'] = $data['factor_potencia'];
            }
            if (isset($data['costo_total'])) {
                $updateData['total_cost'] = $data['costo_total'];
            }
            if (isset($data['eficiencia'])) {
                $updateData['efficiency_percentage'] = $data['eficiencia'];
            }

            // Serie horaria
            if (isset($data['hourly_data']) && is_array($data['hourly_data'])) {
                $updateData['hourly_data'] = $data['hourly_data'];
            }

            $existing->update($updateData);
        } else {
            // Crear nueva evaluación
            $createData = [
                'evaluation_date' => $data['fecha'],
                'risk_level' => $data['nivel_riesgo'],
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
            
            // Campos de energía
            if (isset($data['consumo_total'])) {
                $createData['total_consumption'] = $data['consumo_total'];
            }
            if (isset($data['demanda_maxima'])) {
                $createData['max_demand'] = $data['demanda_maxima'];
            }
            if (isset($data['factor_potencia'])) {
                $createData['power_factor'] = $data['factor_potencia'];
            }
            if (isset($data['costo_total'])) {
                $createData['total_cost'] = $data['costo_total'];
            }
            if (isset($data['eficiencia'])) {
                $createData['efficiency_percentage'] = $data['eficiencia'];
            }

            // Serie horaria
            if (isset($data['hourly_data']) && is_array($data['hourly_data'])) {
                $createData['hourly_data'] = $data['hourly_data'];
            }

            RiskEvaluation::create($createData);
        }
    }

    private function processMonthlyData($data)
    {
        // Parsear fecha a componentes año/mes/día para ajustarse al esquema de la tabla
        $date = Carbon::parse($data['fecha']);

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

            // No hay campo de observaciones en monthly_risk_data

            // Campos de energía (formato legacy)
            if (isset($data['consumo_total'])) {
                $updateData['total_consumption'] = $data['consumo_total'];
            }
            if (isset($data['demanda_maxima'])) {
                $updateData['max_demand'] = $data['demanda_maxima'];
            }
            if (isset($data['factor_potencia'])) {
                $updateData['power_factor'] = $data['factor_potencia'];
            }
            if (isset($data['costo_total'])) {
                $updateData['total_cost'] = $data['costo_total'];
            }
            if (isset($data['eficiencia'])) {
                $updateData['efficiency_percentage'] = $data['eficiencia'];
            }

            $existing->update($updateData);
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

            // No hay campo de observaciones en monthly_risk_data

            // Campos de energía
            if (isset($data['consumo_total'])) {
                $createData['total_consumption'] = $data['consumo_total'];
            }
            if (isset($data['demanda_maxima'])) {
                $createData['max_demand'] = $data['demanda_maxima'];
            }
            if (isset($data['factor_potencia'])) {
                $createData['power_factor'] = $data['factor_potencia'];
            }
            if (isset($data['costo_total'])) {
                $createData['total_cost'] = $data['costo_total'];
            }
            if (isset($data['eficiencia'])) {
                $createData['efficiency_percentage'] = $data['eficiencia'];
            }

            MonthlyRiskData::create($createData);
        }
    }

    /**
     * Limpia y valida los datos del CSV para evitar problemas de codificación
     */
    private function cleanCsvData($data)
    {
        $cleanData = [];
        
        foreach ($data as $rowIndex => $row) {
            $cleanRow = [];
            
            if (is_array($row)) {
                foreach ($row as $cellIndex => $cell) {
                    // Convertir a string si no lo es
                    $cellValue = (string) $cell;
                    
                    // Limpiar caracteres problemáticos
                    $cellValue = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $cellValue);
                    
                    // Normalizar espacios en blanco
                    $cellValue = preg_replace('/\s+/', ' ', $cellValue);
                    
                    // Trim espacios
                    $cellValue = trim($cellValue);
                    
                    // Validar UTF-8
                    if (!mb_check_encoding($cellValue, 'UTF-8')) {
                        $cellValue = mb_convert_encoding($cellValue, 'UTF-8', 'auto');
                    }
                    
                    $cleanRow[] = $cellValue;
                }
            }
            
            $cleanData[] = $cleanRow;
        }
        
        return $cleanData;
    }

    /**
     * Valida que una cadena sea UTF-8 válido
     */
    private function isValidUtf8($str)
    {
        return mb_check_encoding($str, 'UTF-8');
    }

    /**
     * Convierte una cadena a UTF-8 seguro
     */
    private function toSafeUtf8($str)
    {
        // Detectar codificación
        $encoding = mb_detect_encoding($str, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
        
        if ($encoding === false) {
            // Si no se puede detectar, limpiar caracteres problemáticos
            return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F-\xFF]/', '', $str);
        }
        
        if ($encoding !== 'UTF-8') {
            return mb_convert_encoding($str, 'UTF-8', $encoding);
        }
        
        return $str;
    }
}
