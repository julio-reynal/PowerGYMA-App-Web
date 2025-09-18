<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends FormRequest
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
        return [
            'ruc' => [
                'required',
                'string',
                'size:11',
                'regex:/^[0-9]+$/',
                Rule::unique('companies', 'ruc')->ignore($this->company),
            ],
            'razon_social' => [
                'required',
                'string',
                'max:255',
                'min:5',
            ],
            'telefono_fijo' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\d\s\-\+\(\)]+$/',
            ],
            'telefono_celular' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\d\s\-\+\(\)]+$/',
            ],
            'departamento_id' => [
                'nullable',
                'integer',
                'exists:departamentos,id',
            ],
            'provincia_id' => [
                'nullable',
                'integer',
                'exists:provincias,id',
                'required_with:departamento_id',
            ],
            'direccion_calle' => [
                'nullable',
                'string',
                'max:500',
                'min:10',
            ],
            'comentarios' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'ruc.required' => 'El RUC es requerido',
            'ruc.size' => 'El RUC debe tener exactamente 11 dígitos',
            'ruc.regex' => 'El RUC solo debe contener números',
            'ruc.unique' => 'Ya existe una empresa registrada con este RUC',
            
            'razon_social.required' => 'La razón social es requerida',
            'razon_social.min' => 'La razón social debe tener al menos 5 caracteres',
            'razon_social.max' => 'La razón social no debe exceder 255 caracteres',
            
            'telefono_fijo.max' => 'El teléfono fijo no debe exceder 20 caracteres',
            'telefono_fijo.regex' => 'El teléfono fijo contiene caracteres inválidos',
            
            'telefono_celular.max' => 'El teléfono celular no debe exceder 20 caracteres',
            'telefono_celular.regex' => 'El teléfono celular contiene caracteres inválidos',
            
            'departamento_id.exists' => 'El departamento seleccionado no existe',
            'departamento_id.integer' => 'El departamento debe ser un valor válido',
            
            'provincia_id.exists' => 'La provincia seleccionada no existe',
            'provincia_id.integer' => 'La provincia debe ser un valor válido',
            'provincia_id.required_with' => 'La provincia es requerida cuando se selecciona un departamento',
            
            'direccion_calle.min' => 'La dirección debe tener al menos 10 caracteres',
            'direccion_calle.max' => 'La dirección no debe exceder 500 caracteres',
            
            'comentarios.max' => 'Los comentarios no deben exceder 1000 caracteres',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'ruc' => 'RUC',
            'razon_social' => 'razón social',
            'telefono_fijo' => 'teléfono fijo',
            'telefono_celular' => 'teléfono celular',
            'departamento_id' => 'departamento',
            'provincia_id' => 'provincia',
            'direccion_calle' => 'dirección',
            'comentarios' => 'comentarios',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Limpiar el RUC de espacios y caracteres especiales
        if ($this->has('ruc')) {
            $this->merge([
                'ruc' => preg_replace('/[^0-9]/', '', $this->ruc),
            ]);
        }

        // Limpiar y normalizar la razón social
        if ($this->has('razon_social')) {
            $this->merge([
                'razon_social' => trim(preg_replace('/\s+/', ' ', $this->razon_social)),
            ]);
        }

        // Limpiar teléfonos
        if ($this->has('telefono_fijo')) {
            $this->merge([
                'telefono_fijo' => trim($this->telefono_fijo),
            ]);
        }

        if ($this->has('telefono_celular')) {
            $this->merge([
                'telefono_celular' => trim($this->telefono_celular),
            ]);
        }

        // Limpiar dirección
        if ($this->has('direccion_calle')) {
            $this->merge([
                'direccion_calle' => trim(preg_replace('/\s+/', ' ', $this->direccion_calle)),
            ]);
        }

        // Limpiar comentarios
        if ($this->has('comentarios')) {
            $this->merge([
                'comentarios' => trim($this->comentarios),
            ]);
        }
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
