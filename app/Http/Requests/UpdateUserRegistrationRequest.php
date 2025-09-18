<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user') ?? $this->user()?->id;
        
        return [
            // Datos básicos del usuario
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                'regex:/^[\pL\s\-]+$/u',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            
            // Teléfonos del usuario
            'telefono_celular' => [
                'required',
                'string',
                'max:20',
                'regex:/^[\d\s\-\+\(\)]+$/',
            ],
            'telefono_fijo' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\d\s\-\+\(\)]+$/',
            ],
            
            // Datos de empresa
            'empresa_ruc' => [
                'required',
                'string',
                'size:11',
                'regex:/^[0-9]+$/',
            ],
            'empresa_razon_social' => [
                'required',
                'string',
                'max:255',
                'min:5',
            ],
            'empresa_telefono_fijo' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\d\s\-\+\(\)]+$/',
            ],
            
            // Ubicación
            'departamento_id' => [
                'required',
                'integer',
                'exists:departamentos,id',
            ],
            'provincia_id' => [
                'required',
                'integer',
                'exists:provincias,id',
            ],
            'direccion_calle' => [
                'required',
                'string',
                'max:500',
                'min:10',
            ],
            
            // Comentarios
            'comentarios' => [
                'nullable',
                'string',
                'max:1000',
            ],
            
            // Términos y condiciones
            'acepta_terminos' => [
                'required',
                'accepted',
            ],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            // Datos básicos
            'name.required' => 'El nombre es requerido',
            'name.min' => 'El nombre debe tener al menos 2 caracteres',
            'name.max' => 'El nombre no debe exceder 255 caracteres',
            'name.regex' => 'El nombre solo puede contener letras, espacios y guiones',
            
            'email.required' => 'El email es requerido',
            'email.email' => 'El email debe tener un formato válido',
            'email.max' => 'El email no debe exceder 255 caracteres',
            'email.unique' => 'Ya existe un usuario registrado con este email',
            
            // Teléfonos del usuario
            'telefono_celular.required' => 'El teléfono celular es requerido',
            'telefono_celular.max' => 'El teléfono celular no debe exceder 20 caracteres',
            'telefono_celular.regex' => 'El teléfono celular contiene caracteres inválidos',
            
            'telefono_fijo.max' => 'El teléfono fijo no debe exceder 20 caracteres',
            'telefono_fijo.regex' => 'El teléfono fijo contiene caracteres inválidos',
            
            // Empresa
            'empresa_ruc.required' => 'El RUC de la empresa es requerido',
            'empresa_ruc.size' => 'El RUC debe tener exactamente 11 dígitos',
            'empresa_ruc.regex' => 'El RUC solo debe contener números',
            
            'empresa_razon_social.required' => 'La razón social de la empresa es requerida',
            'empresa_razon_social.min' => 'La razón social debe tener al menos 5 caracteres',
            'empresa_razon_social.max' => 'La razón social no debe exceder 255 caracteres',
            
            'empresa_telefono_fijo.max' => 'El teléfono de la empresa no debe exceder 20 caracteres',
            'empresa_telefono_fijo.regex' => 'El teléfono de la empresa contiene caracteres inválidos',
            
            // Ubicación
            'departamento_id.required' => 'El departamento es requerido',
            'departamento_id.exists' => 'El departamento seleccionado no existe',
            'departamento_id.integer' => 'El departamento debe ser un valor válido',
            
            'provincia_id.required' => 'La provincia es requerida',
            'provincia_id.exists' => 'La provincia seleccionada no existe',
            'provincia_id.integer' => 'La provincia debe ser un valor válido',
            
            'direccion_calle.required' => 'La dirección es requerida',
            'direccion_calle.min' => 'La dirección debe tener al menos 10 caracteres',
            'direccion_calle.max' => 'La dirección no debe exceder 500 caracteres',
            
            // Comentarios
            'comentarios.max' => 'Los comentarios no deben exceder 1000 caracteres',
            
            // Términos
            'acepta_terminos.required' => 'Debe aceptar los términos y condiciones',
            'acepta_terminos.accepted' => 'Debe aceptar los términos y condiciones para continuar',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'telefono_celular' => 'teléfono celular',
            'telefono_fijo' => 'teléfono fijo',
            'empresa_ruc' => 'RUC de la empresa',
            'empresa_razon_social' => 'razón social de la empresa',
            'empresa_telefono_fijo' => 'teléfono de la empresa',
            'departamento_id' => 'departamento',
            'provincia_id' => 'provincia',
            'direccion_calle' => 'dirección',
            'comentarios' => 'comentarios',
            'acepta_terminos' => 'términos y condiciones',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Limpiar y normalizar datos
        $cleanData = [];

        // Nombre
        if ($this->has('name')) {
            $cleanData['name'] = trim(preg_replace('/\s+/', ' ', $this->name));
        }

        // Email
        if ($this->has('email')) {
            $cleanData['email'] = strtolower(trim($this->email));
        }

        // RUC
        if ($this->has('empresa_ruc')) {
            $cleanData['empresa_ruc'] = preg_replace('/[^0-9]/', '', $this->empresa_ruc);
        }

        // Razón social
        if ($this->has('empresa_razon_social')) {
            $cleanData['empresa_razon_social'] = trim(preg_replace('/\s+/', ' ', $this->empresa_razon_social));
        }

        // Teléfonos
        if ($this->has('telefono_celular')) {
            $cleanData['telefono_celular'] = trim($this->telefono_celular);
        }

        if ($this->has('telefono_fijo')) {
            $cleanData['telefono_fijo'] = trim($this->telefono_fijo);
        }

        if ($this->has('empresa_telefono_fijo')) {
            $cleanData['empresa_telefono_fijo'] = trim($this->empresa_telefono_fijo);
        }

        // Dirección
        if ($this->has('direccion_calle')) {
            $cleanData['direccion_calle'] = trim(preg_replace('/\s+/', ' ', $this->direccion_calle));
        }

        // Comentarios
        if ($this->has('comentarios')) {
            $cleanData['comentarios'] = trim($this->comentarios);
        }

        // Convertir IDs a enteros
        if ($this->has('departamento_id')) {
            $cleanData['departamento_id'] = (int) $this->departamento_id;
        }

        if ($this->has('provincia_id')) {
            $cleanData['provincia_id'] = (int) $this->provincia_id;
        }

        $this->merge($cleanData);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validar que la provincia pertenezca al departamento seleccionado
            if ($this->departamento_id && $this->provincia_id) {
                $provincia = \App\Models\Provincia::find($this->provincia_id);
                if ($provincia && $provincia->departamento_id != $this->departamento_id) {
                    $validator->errors()->add(
                        'provincia_id',
                        'La provincia seleccionada no pertenece al departamento elegido'
                    );
                }
            }

            // Validar RUC peruano si está presente
            if ($this->empresa_ruc) {
                $companyService = app(\App\Services\CompanyService::class);
                if (!$companyService->validatePeruvianRuc($this->empresa_ruc)) {
                    $validator->errors()->add(
                        'empresa_ruc',
                        'El RUC ingresado no es válido según el algoritmo peruano'
                    );
                }
            }
        });
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->expectsJson()) {
            $response = response()->json([
                'success' => false,
                'message' => 'Los datos enviados no son válidos',
                'errors' => $validator->errors(),
            ], 422);

            throw new \Illuminate\Validation\ValidationException($validator, $response);
        }

        parent::failedValidation($validator);
    }
}
