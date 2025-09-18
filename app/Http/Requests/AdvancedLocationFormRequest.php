<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Departamento;
use App\Models\Provincia;

/**
 * FASE 5: FORMULARIOS Y VALIDACIONES
 * FormRequest avanzado para validación de formularios con ubicaciones
 */
class AdvancedLocationFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ajustar según lógica de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            // Campos básicos comunes
            'nombre' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'apellidos' => [
                'nullable',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user)
            ],
            'telefono' => [
                'nullable',
                'string',
                'regex:/^[+]?[0-9\s\-\(\)]{9,15}$/'
            ],
            'celular' => [
                'nullable',
                'string',
                'regex:/^[+]?[0-9\s\-\(\)]{9,15}$/'
            ],
            
            // Documentos de identidad
            'tipo_documento' => [
                'nullable',
                'string',
                Rule::in(['DNI', 'RUC', 'CE', 'PASAPORTE'])
            ],
            'numero_documento' => [
                'nullable',
                'string',
                'max:20'
            ],
            
            // Ubicación (usando autocompletado)
            'departamento_id' => [
                'required',
                'integer',
                'exists:departamentos,id'
            ],
            'provincia_id' => [
                'required',
                'integer',
                'exists:provincias,id'
            ],
            'direccion' => [
                'nullable',
                'string',
                'max:255'
            ],
            'distrito' => [
                'nullable',
                'string',
                'max:100'
            ],
            'codigo_postal' => [
                'nullable',
                'string',
                'max:10'
            ],
            
            // Información adicional
            'fecha_nacimiento' => [
                'nullable',
                'date',
                'before:today',
                'after:1900-01-01'
            ],
            'genero' => [
                'nullable',
                'string',
                Rule::in(['M', 'F', 'O'])
            ],
            
            // Campos de empresa/gimnasio
            'empresa' => [
                'nullable',
                'string',
                'max:200'
            ],
            'ruc_empresa' => [
                'nullable',
                'string',
                'regex:/^\d{11}$/'
            ],
            'cargo' => [
                'nullable',
                'string',
                'max:100'
            ],
            
            // Campos de contacto de emergencia
            'contacto_emergencia_nombre' => [
                'nullable',
                'string',
                'max:100'
            ],
            'contacto_emergencia_telefono' => [
                'nullable',
                'string',
                'regex:/^[+]?[0-9\s\-\(\)]{9,15}$/'
            ],
            'contacto_emergencia_relacion' => [
                'nullable',
                'string',
                'max:50'
            ],
            
            // Preferencias
            'acepta_terminos' => [
                'required',
                'accepted'
            ],
            'acepta_comunicaciones' => [
                'nullable',
                'boolean'
            ],
            'acepta_datos_terceros' => [
                'nullable',
                'boolean'
            ],
            
            // Campos técnicos
            '_validation_level' => [
                'nullable',
                'string',
                Rule::in(['basic', 'advanced', 'strict'])
            ],
            '_form_version' => [
                'nullable',
                'string'
            ]
        ];

        // Aplicar reglas específicas según el tipo de documento
        $this->applyDocumentValidationRules($rules);
        
        // Aplicar validaciones condicionales
        $this->applyConditionalRules($rules);

        return $rules;
    }

    /**
     * Aplicar reglas de validación específicas para documentos
     */
    protected function applyDocumentValidationRules(array &$rules): void
    {
        $tipoDocumento = $this->input('tipo_documento');
        $numeroDocumento = $this->input('numero_documento');

        if ($tipoDocumento && $numeroDocumento) {
            switch ($tipoDocumento) {
                case 'DNI':
                    $rules['numero_documento'][] = 'regex:/^\d{8}$/';
                    $rules['numero_documento'][] = Rule::unique('users', 'numero_documento')
                        ->where('tipo_documento', 'DNI')
                        ->ignore($this->user);
                    break;
                    
                case 'RUC':
                    $rules['numero_documento'][] = 'regex:/^\d{11}$/';
                    $rules['numero_documento'][] = Rule::unique('users', 'numero_documento')
                        ->where('tipo_documento', 'RUC')
                        ->ignore($this->user);
                    break;
                    
                case 'CE':
                    $rules['numero_documento'][] = 'regex:/^\d{9}$/';
                    break;
                    
                case 'PASAPORTE':
                    $rules['numero_documento'][] = 'regex:/^[A-Z0-9]{6,12}$/';
                    break;
            }
        }
    }

    /**
     * Aplicar reglas condicionales
     */
    protected function applyConditionalRules(array &$rules): void
    {
        // Si se proporciona empresa, RUC es requerido
        if ($this->filled('empresa')) {
            $rules['ruc_empresa'] = array_merge(
                $rules['ruc_empresa'] ?? [],
                ['required']
            );
        }

        // Si se proporciona contacto de emergencia, todos los campos son requeridos
        if ($this->filled('contacto_emergencia_nombre')) {
            $rules['contacto_emergencia_telefono'] = array_merge(
                $rules['contacto_emergencia_telefono'] ?? [],
                ['required']
            );
            $rules['contacto_emergencia_relacion'] = array_merge(
                $rules['contacto_emergencia_relacion'] ?? [],
                ['required']
            );
        }

        // Validar que la provincia pertenezca al departamento
        if ($this->filled(['departamento_id', 'provincia_id'])) {
            $rules['provincia_id'][] = function ($attribute, $value, $fail) {
                $departamentoId = $this->input('departamento_id');
                
                $provincia = Provincia::where('id', $value)
                    ->where('departamento_id', $departamentoId)
                    ->first();
                
                if (!$provincia) {
                    $fail('La provincia seleccionada no pertenece al departamento especificado.');
                }
            };
        }
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // Mensajes para campos básicos
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            
            'apellidos.min' => 'Los apellidos deben tener al menos 2 caracteres.',
            'apellidos.max' => 'Los apellidos no pueden tener más de 100 caracteres.',
            'apellidos.regex' => 'Los apellidos solo pueden contener letras y espacios.',
            
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Ingrese un email válido.',
            'email.unique' => 'Este email ya está registrado.',
            
            'telefono.regex' => 'Ingrese un número de teléfono válido.',
            'celular.regex' => 'Ingrese un número de celular válido.',
            
            // Mensajes para documentos
            'tipo_documento.in' => 'Seleccione un tipo de documento válido.',
            'numero_documento.regex' => 'El formato del documento no es válido.',
            'numero_documento.unique' => 'Este número de documento ya está registrado.',
            
            // Mensajes para ubicación
            'departamento_id.required' => 'Debe seleccionar un departamento.',
            'departamento_id.exists' => 'El departamento seleccionado no es válido.',
            'provincia_id.required' => 'Debe seleccionar una provincia.',
            'provincia_id.exists' => 'La provincia seleccionada no es válida.',
            
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',
            'distrito.max' => 'El distrito no puede tener más de 100 caracteres.',
            'codigo_postal.max' => 'El código postal no puede tener más de 10 caracteres.',
            
            // Mensajes para información personal
            'fecha_nacimiento.date' => 'Ingrese una fecha válida.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'fecha_nacimiento.after' => 'Ingrese una fecha de nacimiento válida.',
            'genero.in' => 'Seleccione un género válido.',
            
            // Mensajes para empresa
            'empresa.max' => 'El nombre de la empresa no puede tener más de 200 caracteres.',
            'ruc_empresa.regex' => 'El RUC debe tener 11 dígitos.',
            'ruc_empresa.required' => 'El RUC es obligatorio cuando se especifica una empresa.',
            'cargo.max' => 'El cargo no puede tener más de 100 caracteres.',
            
            // Mensajes para contacto de emergencia
            'contacto_emergencia_nombre.max' => 'El nombre del contacto no puede tener más de 100 caracteres.',
            'contacto_emergencia_telefono.regex' => 'Ingrese un teléfono de contacto válido.',
            'contacto_emergencia_telefono.required' => 'El teléfono de contacto es obligatorio.',
            'contacto_emergencia_relacion.max' => 'La relación no puede tener más de 50 caracteres.',
            'contacto_emergencia_relacion.required' => 'La relación con el contacto es obligatoria.',
            
            // Mensajes para términos
            'acepta_terminos.required' => 'Debe aceptar los términos y condiciones.',
            'acepta_terminos.accepted' => 'Debe aceptar los términos y condiciones.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nombre' => 'nombre',
            'apellidos' => 'apellidos',
            'email' => 'correo electrónico',
            'telefono' => 'teléfono',
            'celular' => 'celular',
            'tipo_documento' => 'tipo de documento',
            'numero_documento' => 'número de documento',
            'departamento_id' => 'departamento',
            'provincia_id' => 'provincia',
            'direccion' => 'dirección',
            'distrito' => 'distrito',
            'codigo_postal' => 'código postal',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'genero' => 'género',
            'empresa' => 'empresa',
            'ruc_empresa' => 'RUC de la empresa',
            'cargo' => 'cargo',
            'contacto_emergencia_nombre' => 'nombre del contacto de emergencia',
            'contacto_emergencia_telefono' => 'teléfono del contacto de emergencia',
            'contacto_emergencia_relacion' => 'relación con el contacto de emergencia',
            'acepta_terminos' => 'términos y condiciones',
            'acepta_comunicaciones' => 'comunicaciones comerciales',
            'acepta_datos_terceros' => 'cesión de datos a terceros'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Limpiar y formatear datos antes de la validación
        $this->merge([
            'nombre' => $this->cleanTextInput($this->nombre),
            'apellidos' => $this->cleanTextInput($this->apellidos),
            'email' => strtolower(trim($this->email ?? '')),
            'telefono' => $this->cleanPhoneInput($this->telefono),
            'celular' => $this->cleanPhoneInput($this->celular),
            'numero_documento' => $this->cleanDocumentInput($this->numero_documento),
            'ruc_empresa' => $this->cleanDocumentInput($this->ruc_empresa),
            'direccion' => $this->cleanTextInput($this->direccion),
            'distrito' => $this->cleanTextInput($this->distrito),
            'empresa' => $this->cleanTextInput($this->empresa),
            'cargo' => $this->cleanTextInput($this->cargo),
            'contacto_emergencia_nombre' => $this->cleanTextInput($this->contacto_emergencia_nombre),
            'contacto_emergencia_telefono' => $this->cleanPhoneInput($this->contacto_emergencia_telefono),
            'contacto_emergencia_relacion' => $this->cleanTextInput($this->contacto_emergencia_relacion),
        ]);
    }

    /**
     * Limpiar entrada de texto
     */
    protected function cleanTextInput(?string $input): ?string
    {
        if (!$input) return null;
        
        return trim(preg_replace('/\s+/', ' ', $input));
    }

    /**
     * Limpiar entrada de teléfono
     */
    protected function cleanPhoneInput(?string $input): ?string
    {
        if (!$input) return null;
        
        // Remover espacios extra pero mantener formato básico
        return trim(preg_replace('/\s{2,}/', ' ', $input));
    }

    /**
     * Limpiar entrada de documento
     */
    protected function cleanDocumentInput(?string $input): ?string
    {
        if (!$input) return null;
        
        // Remover espacios y caracteres especiales, mantener solo alfanuméricos
        return preg_replace('/[^A-Za-z0-9]/', '', trim($input));
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors();
        
        // Log de errores para debugging
        if (config('app.debug')) {
            \Log::warning('Validación de formulario fallida', [
                'url' => $this->url(),
                'errors' => $errors->toArray(),
                'input' => $this->except(['password', 'password_confirmation'])
            ]);
        }

        // Si es una petición AJAX, retornar JSON
        if ($this->expectsJson()) {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => 'Los datos proporcionados no son válidos.',
                    'errors' => $errors->toArray(),
                    'error_count' => $errors->count()
                ], 422)
            );
        }

        // Comportamiento estándar para peticiones normales
        parent::failedValidation($validator);
    }

    /**
     * Get validated data with additional processing
     */
    public function getValidatedData(): array
    {
        $validated = $this->validated();
        
        // Agregar campos calculados
        $validated['nombre_completo'] = trim(($validated['nombre'] ?? '') . ' ' . ($validated['apellidos'] ?? ''));
        $validated['validated_at'] = now();
        $validated['validation_level'] = $this->input('_validation_level', 'advanced');
        
        // Limpiar campos técnicos
        unset($validated['_validation_level'], $validated['_form_version']);
        
        return $validated;
    }

    /**
     * Get location data separately
     */
    public function getLocationData(): array
    {
        return [
            'departamento_id' => $this->validated()['departamento_id'] ?? null,
            'provincia_id' => $this->validated()['provincia_id'] ?? null,
            'direccion' => $this->validated()['direccion'] ?? null,
            'distrito' => $this->validated()['distrito'] ?? null,
            'codigo_postal' => $this->validated()['codigo_postal'] ?? null,
        ];
    }

    /**
     * Get contact data separately
     */
    public function getContactData(): array
    {
        return [
            'telefono' => $this->validated()['telefono'] ?? null,
            'celular' => $this->validated()['celular'] ?? null,
            'email' => $this->validated()['email'] ?? null,
        ];
    }

    /**
     * Get emergency contact data
     */
    public function getEmergencyContactData(): array
    {
        return [
            'nombre' => $this->validated()['contacto_emergencia_nombre'] ?? null,
            'telefono' => $this->validated()['contacto_emergencia_telefono'] ?? null,
            'relacion' => $this->validated()['contacto_emergencia_relacion'] ?? null,
        ];
    }
}
