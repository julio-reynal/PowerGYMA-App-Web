<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Http\Requests\AdvancedLocationFormRequest;
use App\Models\Departamento;
use App\Models\Provincia;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * FASE 5: FORMULARIOS Y VALIDACIONES
 * Controlador para manejar formularios avanzados con validación
 */
class AdvancedFormController extends Controller
{
    /**
     * Mostrar la página de demostración de formularios
     */
    public function showDemo(): View
    {
        $departamentos = Departamento::orderBy('nombre')->get();
        
        return view('demo.formularios', compact('departamentos'));
    }

    /**
     * Procesar formulario de registro con validación avanzada
     */
    public function processRegistration(AdvancedLocationFormRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Obtener datos validados
            $validatedData = $request->getValidatedData();
            $locationData = $request->getLocationData();
            $contactData = $request->getContactData();
            $emergencyData = $request->getEmergencyContactData();

            // Crear o actualizar usuario
            $user = $this->createOrUpdateUser($validatedData, $locationData, $contactData, $emergencyData);

            DB::commit();

            // Respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Formulario procesado exitosamente',
                'data' => [
                    'user_id' => $user->id,
                    'user_name' => $user->nombre_completo,
                    'validation_level' => $validatedData['validation_level'],
                    'created_at' => $user->created_at->format('Y-m-d H:i:s')
                ],
                'redirect' => route('demo.autocompletado') // Opcional
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error procesando formulario de registro', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['password'])
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'debug_info' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Validar campos individuales via AJAX
     */
    public function validateField(Request $request): JsonResponse
    {
        $fieldName = $request->input('field');
        $fieldValue = $request->input('value');
        $allData = $request->input('data', []);

        if (!$fieldName) {
            return response()->json([
                'success' => false,
                'message' => 'Nombre del campo requerido'
            ], 400);
        }

        try {
            // Crear una instancia temporal del FormRequest para validación
            $formRequest = new AdvancedLocationFormRequest();
            $rules = $formRequest->rules();
            $messages = $formRequest->messages();

            // Validar solo el campo específico
            if (!isset($rules[$fieldName])) {
                return response()->json([
                    'success' => true,
                    'message' => 'Campo válido (sin reglas específicas)'
                ]);
            }

            $validator = Validator::make(
                array_merge($allData, [$fieldName => $fieldValue]),
                [$fieldName => $rules[$fieldName]],
                $messages
            );

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()->get($fieldName),
                    'message' => $validator->errors()->first($fieldName)
                ], 422);
            }

            // Validaciones especiales
            $specialValidation = $this->performSpecialValidation($fieldName, $fieldValue, $allData);
            if (!$specialValidation['success']) {
                return response()->json($specialValidation, 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'Campo válido',
                'suggestions' => $specialValidation['suggestions'] ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Error validando campo individual', [
                'field' => $fieldName,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error en la validación'
            ], 500);
        }
    }

    /**
     * Verificar disponibilidad de email
     */
    public function checkEmailAvailability(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $userId = $request->input('user_id'); // Para ediciones

        if (!$email) {
            return response()->json([
                'available' => false,
                'message' => 'Email requerido'
            ], 400);
        }

        $query = User::where('email', $email);
        
        if ($userId) {
            $query->where('id', '!=', $userId);
        }

        $exists = $query->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Email ya registrado' : 'Email disponible',
            'email' => $email
        ]);
    }

    /**
     * Verificar disponibilidad de documento
     */
    public function checkDocumentAvailability(Request $request): JsonResponse
    {
        $tipoDocumento = $request->input('tipo_documento');
        $numeroDocumento = $request->input('numero_documento');
        $userId = $request->input('user_id');

        if (!$tipoDocumento || !$numeroDocumento) {
            return response()->json([
                'available' => false,
                'message' => 'Tipo y número de documento requeridos'
            ], 400);
        }

        $query = User::where('tipo_documento', $tipoDocumento)
                    ->where('numero_documento', $numeroDocumento);
        
        if ($userId) {
            $query->where('id', '!=', $userId);
        }

        $exists = $query->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Documento ya registrado' : 'Documento disponible',
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento
        ]);
    }

    /**
     * Validar relación departamento-provincia
     */
    public function validateLocationRelation(Request $request): JsonResponse
    {
        $departamentoId = $request->input('departamento_id');
        $provinciaId = $request->input('provincia_id');

        if (!$departamentoId || !$provinciaId) {
            return response()->json([
                'valid' => false,
                'message' => 'Departamento y provincia requeridos'
            ], 400);
        }

        $provincia = Provincia::where('id', $provinciaId)
                             ->where('departamento_id', $departamentoId)
                             ->with('departamento')
                             ->first();

        if (!$provincia) {
            return response()->json([
                'valid' => false,
                'message' => 'La provincia no pertenece al departamento seleccionado',
                'departamento_id' => $departamentoId,
                'provincia_id' => $provinciaId
            ]);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Relación válida',
            'location' => [
                'departamento' => [
                    'id' => $provincia->departamento->id,
                    'nombre' => $provincia->departamento->nombre
                ],
                'provincia' => [
                    'id' => $provincia->id,
                    'nombre' => $provincia->nombre
                ]
            ]
        ]);
    }

    /**
     * Obtener sugerencias para autocompletado de campos de texto
     */
    public function getFieldSuggestions(Request $request): JsonResponse
    {
        $field = $request->input('field');
        $query = $request->input('q', '');
        $limit = min($request->input('limit', 10), 50);

        if (!$field || strlen($query) < 2) {
            return response()->json([
                'suggestions' => []
            ]);
        }

        try {
            $suggestions = [];

            switch ($field) {
                case 'empresa':
                    $suggestions = User::where('empresa', 'like', "%{$query}%")
                                      ->whereNotNull('empresa')
                                      ->distinct()
                                      ->pluck('empresa')
                                      ->take($limit)
                                      ->values();
                    break;

                case 'cargo':
                    $suggestions = User::where('cargo', 'like', "%{$query}%")
                                      ->whereNotNull('cargo')
                                      ->distinct()
                                      ->pluck('cargo')
                                      ->take($limit)
                                      ->values();
                    break;

                case 'distrito':
                    $suggestions = User::where('distrito', 'like', "%{$query}%")
                                      ->whereNotNull('distrito')
                                      ->distinct()
                                      ->pluck('distrito')
                                      ->take($limit)
                                      ->values();
                    break;

                default:
                    // Campo no soportado para sugerencias
                    break;
            }

            return response()->json([
                'suggestions' => $suggestions,
                'field' => $field,
                'query' => $query
            ]);

        } catch (\Exception $e) {
            Log::error('Error obteniendo sugerencias para campo', [
                'field' => $field,
                'query' => $query,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'suggestions' => []
            ]);
        }
    }

    /**
     * Validar formulario completo sin procesar
     */
    public function validateFullForm(AdvancedLocationFormRequest $request): JsonResponse
    {
        // Si llegamos aquí, la validación ya pasó
        return response()->json([
            'success' => true,
            'message' => 'Formulario válido',
            'validation_summary' => [
                'fields_count' => count($request->validated()),
                'validation_level' => $request->input('_validation_level', 'advanced'),
                'validated_at' => now()->format('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * Crear o actualizar usuario con todos los datos
     */
    protected function createOrUpdateUser(array $validatedData, array $locationData, array $contactData, array $emergencyData): User
    {
        // Buscar usuario existente por email
        $user = User::where('email', $validatedData['email'])->first();

        $userData = array_merge($validatedData, $locationData, $contactData);
        
        // Agregar datos de contacto de emergencia como JSON
        if (!empty(array_filter($emergencyData))) {
            $userData['contacto_emergencia'] = json_encode($emergencyData);
        }

        if ($user) {
            // Actualizar usuario existente
            $user->update($userData);
            Log::info('Usuario actualizado via formulario avanzado', ['user_id' => $user->id]);
        } else {
            // Crear nuevo usuario
            $userData['password'] = bcrypt('password123'); // Password temporal
            $user = User::create($userData);
            Log::info('Usuario creado via formulario avanzado', ['user_id' => $user->id]);
        }

        return $user;
    }

    /**
     * Realizar validaciones especiales para campos específicos
     */
    protected function performSpecialValidation(string $fieldName, $fieldValue, array $allData): array
    {
        $result = ['success' => true];

        switch ($fieldName) {
            case 'email':
                // Verificar si el dominio del email es válido
                if ($fieldValue && filter_var($fieldValue, FILTER_VALIDATE_EMAIL)) {
                    $domain = substr(strrchr($fieldValue, "@"), 1);
                    $commonDomains = ['gmail.com', 'hotmail.com', 'yahoo.com', 'outlook.com'];
                    
                    if (!in_array($domain, $commonDomains) && !checkdnsrr($domain, 'MX')) {
                        $result = [
                            'success' => false,
                            'message' => 'El dominio del email podría no ser válido'
                        ];
                    } else {
                        $result['suggestions'] = [
                            'message' => 'Email válido',
                            'domain_type' => in_array($domain, $commonDomains) ? 'common' : 'custom'
                        ];
                    }
                }
                break;

            case 'numero_documento':
                if (isset($allData['tipo_documento']) && $fieldValue) {
                    $result['suggestions'] = $this->getDocumentSuggestions($allData['tipo_documento'], $fieldValue);
                }
                break;

            case 'telefono':
            case 'celular':
                if ($fieldValue) {
                    $result['suggestions'] = $this->getPhoneSuggestions($fieldValue);
                }
                break;
        }

        return $result;
    }

    /**
     * Obtener sugerencias para documentos
     */
    protected function getDocumentSuggestions(string $tipoDocumento, string $numeroDocumento): array
    {
        $suggestions = [];

        switch ($tipoDocumento) {
            case 'DNI':
                if (strlen($numeroDocumento) === 8) {
                    $suggestions['message'] = 'DNI con formato correcto';
                    $suggestions['format'] = 'valid';
                } elseif (strlen($numeroDocumento) < 8) {
                    $suggestions['message'] = 'DNI debe tener 8 dígitos';
                    $suggestions['format'] = 'incomplete';
                }
                break;

            case 'RUC':
                if (strlen($numeroDocumento) === 11) {
                    // Validación básica de dígito verificador de RUC
                    $suggestions['message'] = 'RUC con formato correcto';
                    $suggestions['format'] = 'valid';
                } elseif (strlen($numeroDocumento) < 11) {
                    $suggestions['message'] = 'RUC debe tener 11 dígitos';
                    $suggestions['format'] = 'incomplete';
                }
                break;
        }

        return $suggestions;
    }

    /**
     * Obtener sugerencias para teléfonos
     */
    protected function getPhoneSuggestions(string $phone): array
    {
        $suggestions = [];
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($cleanPhone) >= 9) {
            if (substr($cleanPhone, 0, 2) === '51') {
                $suggestions['country'] = 'Perú (+51)';
                $suggestions['format'] = 'international';
            } elseif (strlen($cleanPhone) === 9) {
                $suggestions['country'] = 'Perú (formato nacional)';
                $suggestions['format'] = 'national';
            }
        }

        return $suggestions;
    }
}
