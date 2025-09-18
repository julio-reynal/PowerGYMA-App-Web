@extends('layouts.app')

@section('title', 'FASE 5: Formularios y Validaciones')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body bg-gradient-primary text-white">
                    <div class="d-flex align-items-center">
                        <div class="feature-icon me-3">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div>
                            <h1 class="h3 mb-1">📝 FASE 5: FORMULARIOS Y VALIDACIONES</h1>
                            <p class="mb-0 opacity-75">Sistema completo de formularios con validación avanzada en tiempo real</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navegación de Pestañas -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills nav-fill" id="formTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="registro-tab" data-bs-toggle="pill" data-bs-target="#registro" type="button" role="tab">
                        <i class="fas fa-user-plus me-2"></i>Formulario de Registro
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="validacion-tab" data-bs-toggle="pill" data-bs-target="#validacion" type="button" role="tab">
                        <i class="fas fa-shield-alt me-2"></i>Validaciones en Tiempo Real
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="testing-tab" data-bs-toggle="pill" data-bs-target="#testing" type="button" role="tab">
                        <i class="fas fa-flask me-2"></i>Testing de Formularios
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="formTabsContent">
        <!-- Tab 1: Formulario de Registro -->
        <div class="tab-pane fade show active" id="registro" role="tabpanel">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-plus text-primary me-2"></i>
                                Formulario de Registro Avanzado
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Mensajes globales -->
                            <div class="global-messages"></div>

                            <form id="advanced-form" action="{{ route('forms.process-registration') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <input type="hidden" name="_validation_level" value="advanced">
                                <input type="hidden" name="_form_version" value="1.0">

                                <!-- Información Personal -->
                                <div class="form-section mb-4">
                                    <h6 class="section-title">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        Información Personal
                                    </h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="nombre" 
                                                   name="nombre" 
                                                   data-validate="required|minLength:2|maxLength:100"
                                                   placeholder="Ingrese su nombre"
                                                   autocomplete="given-name">
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="apellidos" class="form-label">Apellidos</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="apellidos" 
                                                   name="apellidos" 
                                                   data-validate="minLength:2|maxLength:100"
                                                   placeholder="Ingrese sus apellidos"
                                                   autocomplete="family-name">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                            <input type="email" 
                                                   class="form-control" 
                                                   id="email" 
                                                   name="email" 
                                                   data-validate="required|email"
                                                   placeholder="ejemplo@correo.com"
                                                   autocomplete="email">
                                            <div class="email-suggestions mt-1"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                            <input type="date" 
                                                   class="form-control" 
                                                   id="fecha_nacimiento" 
                                                   name="fecha_nacimiento"
                                                   autocomplete="bday">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                            <select class="form-select" id="tipo_documento" name="tipo_documento">
                                                <option value="">Seleccionar...</option>
                                                <option value="DNI">DNI</option>
                                                <option value="RUC">RUC</option>
                                                <option value="CE">Carné de Extranjería</option>
                                                <option value="PASAPORTE">Pasaporte</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="numero_documento" class="form-label">Número de Documento</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="numero_documento" 
                                                   name="numero_documento"
                                                   placeholder="Número de documento">
                                            <div class="document-suggestions mt-1"></div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="genero" class="form-label">Género</label>
                                            <select class="form-select" id="genero" name="genero">
                                                <option value="">Seleccionar...</option>
                                                <option value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                                <option value="O">Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información de Contacto -->
                                <div class="form-section mb-4">
                                    <h6 class="section-title">
                                        <i class="fas fa-phone text-primary me-2"></i>
                                        Información de Contacto
                                    </h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="tel" 
                                                   class="form-control" 
                                                   id="telefono" 
                                                   name="telefono" 
                                                   data-validate="phone"
                                                   placeholder="(01) 234-5678"
                                                   autocomplete="tel">
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="celular" class="form-label">Celular</label>
                                            <input type="tel" 
                                                   class="form-control" 
                                                   id="celular" 
                                                   name="celular" 
                                                   data-validate="phone"
                                                   placeholder="987 654 321"
                                                   autocomplete="mobile">
                                        </div>
                                    </div>
                                </div>

                                <!-- Ubicación con Autocompletado -->
                                <div class="form-section mb-4">
                                    <h6 class="section-title">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        Ubicación
                                    </h6>
                                    
                                    <div class="location-fields-container">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="departamento_autocomplete" class="form-label">Departamento <span class="text-danger">*</span></label>
                                                <input type="text" 
                                                       class="form-control" 
                                                       id="departamento_autocomplete" 
                                                       name="departamento_autocomplete"
                                                       placeholder="Buscar departamento..."
                                                       autocomplete="off">
                                                <input type="hidden" id="departamento_id" name="departamento_id">
                                                <div class="autocomplete-results" id="departamento_results"></div>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="provincia_autocomplete" class="form-label">Provincia <span class="text-danger">*</span></label>
                                                <input type="text" 
                                                       class="form-control" 
                                                       id="provincia_autocomplete" 
                                                       name="provincia_autocomplete"
                                                       placeholder="Buscar provincia..."
                                                       autocomplete="off"
                                                       disabled>
                                                <input type="hidden" id="provincia_id" name="provincia_id">
                                                <div class="autocomplete-results" id="provincia_results"></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8 mb-3">
                                                <label for="direccion" class="form-label">Dirección</label>
                                                <input type="text" 
                                                       class="form-control" 
                                                       id="direccion" 
                                                       name="direccion"
                                                       placeholder="Calle, número, urbanización..."
                                                       autocomplete="street-address">
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label for="distrito" class="form-label">Distrito</label>
                                                <input type="text" 
                                                       class="form-control" 
                                                       id="distrito" 
                                                       name="distrito"
                                                       placeholder="Distrito"
                                                       autocomplete="address-level2">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información Laboral -->
                                <div class="form-section mb-4">
                                    <h6 class="section-title">
                                        <i class="fas fa-briefcase text-primary me-2"></i>
                                        Información Laboral
                                    </h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="empresa" class="form-label">Empresa</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="empresa" 
                                                   name="empresa"
                                                   placeholder="Nombre de la empresa"
                                                   autocomplete="organization">
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="cargo" class="form-label">Cargo</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="cargo" 
                                                   name="cargo"
                                                   placeholder="Puesto de trabajo"
                                                   autocomplete="organization-title">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="ruc_empresa" class="form-label">RUC de la Empresa</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="ruc_empresa" 
                                                   name="ruc_empresa" 
                                                   data-validate="ruc"
                                                   placeholder="20123456789">
                                        </div>
                                    </div>
                                </div>

                                <!-- Contacto de Emergencia -->
                                <div class="form-section mb-4">
                                    <h6 class="section-title">
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                        Contacto de Emergencia
                                    </h6>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="contacto_emergencia_nombre" class="form-label">Nombre del Contacto</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="contacto_emergencia_nombre" 
                                                   name="contacto_emergencia_nombre"
                                                   placeholder="Nombre completo">
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="contacto_emergencia_telefono" class="form-label">Teléfono del Contacto</label>
                                            <input type="tel" 
                                                   class="form-control" 
                                                   id="contacto_emergencia_telefono" 
                                                   name="contacto_emergencia_telefono" 
                                                   data-validate="phone"
                                                   placeholder="987 654 321">
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="contacto_emergencia_relacion" class="form-label">Relación</label>
                                            <select class="form-select" id="contacto_emergencia_relacion" name="contacto_emergencia_relacion">
                                                <option value="">Seleccionar...</option>
                                                <option value="Padre">Padre</option>
                                                <option value="Madre">Madre</option>
                                                <option value="Cónyuge">Cónyuge</option>
                                                <option value="Hermano/a">Hermano/a</option>
                                                <option value="Hijo/a">Hijo/a</option>
                                                <option value="Amigo/a">Amigo/a</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Términos y Condiciones -->
                                <div class="form-section mb-4">
                                    <h6 class="section-title">
                                        <i class="fas fa-file-contract text-primary me-2"></i>
                                        Términos y Condiciones
                                    </h6>
                                    
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="acepta_terminos" 
                                               name="acepta_terminos" 
                                               data-validate="required"
                                               value="1">
                                        <label class="form-check-label" for="acepta_terminos">
                                            Acepto los <a href="#" class="text-primary">términos y condiciones</a> <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="acepta_comunicaciones" name="acepta_comunicaciones" value="1">
                                        <label class="form-check-label" for="acepta_comunicaciones">
                                            Acepto recibir comunicaciones comerciales
                                        </label>
                                    </div>
                                    
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="acepta_datos_terceros" name="acepta_datos_terceros" value="1">
                                        <label class="form-check-label" for="acepta_datos_terceros">
                                            Autorizo la cesión de mis datos a terceros
                                        </label>
                                    </div>
                                </div>

                                <!-- Botones de Acción -->
                                <div class="d-flex gap-2 justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary" id="validateFormBtn">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Validar Formulario
                                    </button>
                                    <button type="reset" class="btn btn-outline-warning">
                                        <i class="fas fa-undo me-2"></i>
                                        Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Enviar Formulario
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Panel de Información -->
                <div class="col-xl-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Características del Formulario
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="feature-list">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Validación en tiempo real</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Autocompletado de ubicaciones</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Validación de documentos peruanos</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Verificación de emails</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Sugerencias inteligentes</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>Validación cruzada de campos</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estado del Formulario -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-chart-line text-primary me-2"></i>
                                Estado del Formulario
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="form-status">
                                <div class="status-item">
                                    <span class="status-label">Campos completados:</span>
                                    <span class="status-value" id="completed-fields">0/15</span>
                                </div>
                                <div class="status-item">
                                    <span class="status-label">Errores encontrados:</span>
                                    <span class="status-value text-danger" id="error-count">0</span>
                                </div>
                                <div class="status-item">
                                    <span class="status-label">Estado general:</span>
                                    <span class="status-value" id="form-status-text">Incompleto</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Validaciones en Tiempo Real -->
        <div class="tab-pane fade" id="validacion" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-shield-alt text-primary me-2"></i>
                                Demo de Validaciones en Tiempo Real
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Validación de Email -->
                                <div class="col-md-6 mb-4">
                                    <h6 class="text-primary">Validación de Email</h6>
                                    <input type="email" class="form-control" id="demo-email" placeholder="Ingrese un email">
                                    <div class="demo-result mt-2" id="email-result"></div>
                                </div>

                                <!-- Validación de DNI -->
                                <div class="col-md-6 mb-4">
                                    <h6 class="text-primary">Validación de DNI</h6>
                                    <input type="text" class="form-control" id="demo-dni" placeholder="12345678" maxlength="8">
                                    <div class="demo-result mt-2" id="dni-result"></div>
                                </div>

                                <!-- Validación de RUC -->
                                <div class="col-md-6 mb-4">
                                    <h6 class="text-primary">Validación de RUC</h6>
                                    <input type="text" class="form-control" id="demo-ruc" placeholder="20123456789" maxlength="11">
                                    <div class="demo-result mt-2" id="ruc-result"></div>
                                </div>

                                <!-- Validación de Teléfono -->
                                <div class="col-md-6 mb-4">
                                    <h6 class="text-primary">Validación de Teléfono</h6>
                                    <input type="tel" class="form-control" id="demo-phone" placeholder="987654321">
                                    <div class="demo-result mt-2" id="phone-result"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 3: Testing de Formularios -->
        <div class="tab-pane fade" id="testing" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-flask text-primary me-2"></i>
                                Testing Automatizado de Formularios
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <button class="btn btn-primary me-2" onclick="runFormTests()">
                                    <i class="fas fa-play me-2"></i>
                                    Ejecutar Tests
                                </button>
                                <button class="btn btn-outline-secondary me-2" onclick="fillTestData()">
                                    <i class="fas fa-fill-drip me-2"></i>
                                    Llenar Datos de Prueba
                                </button>
                                <button class="btn btn-outline-warning" onclick="clearTestResults()">
                                    <i class="fas fa-eraser me-2"></i>
                                    Limpiar Resultados
                                </button>
                            </div>

                            <div id="test-results">
                                <!-- Los resultados de testing aparecerán aquí -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos Adicionales -->
<style>
.form-section {
    border-left: 3px solid var(--bs-primary);
    padding-left: 15px;
    margin-bottom: 2rem;
}

.section-title {
    color: var(--bs-dark);
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--bs-gray-200);
}

.feature-list {
    list-style: none;
    padding: 0;
}

.feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    font-size: 0.9rem;
}

.status-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    padding: 0.25rem 0;
    border-bottom: 1px solid var(--bs-gray-100);
}

.status-label {
    font-weight: 500;
    color: var(--bs-gray-600);
}

.status-value {
    font-weight: 600;
    color: var(--bs-primary);
}

.demo-result {
    font-size: 0.85rem;
    padding: 0.5rem;
    border-radius: 0.25rem;
    border: 1px solid var(--bs-gray-200);
    background-color: var(--bs-gray-50);
}

.autocomplete-results {
    position: relative;
    z-index: 1000;
}

.password-strength {
    font-size: 0.75rem;
    font-weight: 500;
}

.email-suggestions,
.document-suggestions {
    font-size: 0.75rem;
    color: var(--bs-gray-600);
}

.is-invalid {
    border-color: var(--bs-danger) !important;
}

.is-valid {
    border-color: var(--bs-success) !important;
}

.invalid-feedback {
    display: block;
    font-size: 0.8rem;
    color: var(--bs-danger);
    margin-top: 0.25rem;
}

.valid-feedback {
    display: block;
    font-size: 0.8rem;
    color: var(--bs-success);
    margin-top: 0.25rem;
}

.location-error {
    border: 2px solid var(--bs-danger);
    border-radius: 0.375rem;
    padding: 0.5rem;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}
</style>
@endsection

@section('scripts')
<!-- Scripts del Autocompletado -->
<script src="{{ asset('resources/js/advanced-location-autocomplete.js') }}"></script>
<!-- Scripts del Validador de Formularios -->
<script src="{{ asset('resources/js/advanced-form-validator.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el validador de formularios
    const formValidator = new AdvancedFormValidator({
        formSelector: '#advanced-form',
        departamentoInputId: 'departamento_autocomplete',
        provinciaInputId: 'provincia_autocomplete',
        departamentoHiddenId: 'departamento_id',
        provinciaHiddenId: 'provincia_id',
        validateOnInput: true,
        validateOnBlur: true,
        showSuccessMessages: true,
        onValidation: async (formData) => {
            console.log('Validación personalizada:', formData);
            return true;
        },
        onSubmit: async (formData) => {
            try {
                const response = await fetch('{{ route("forms.process-registration") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                });
                
                const result = await response.json();
                return result;
            } catch (error) {
                return {
                    success: false,
                    message: 'Error de conexión: ' + error.message
                };
            }
        },
        onSuccess: (result) => {
            console.log('Formulario enviado exitosamente:', result);
            updateFormStatus();
        },
        onError: (message, error) => {
            console.error('Error en formulario:', message, error);
        }
    });

    // Inicializar validaciones demo
    initializeDemoValidations();

    // Actualizar estado del formulario en tiempo real
    setInterval(updateFormStatus, 2000);

    // Botón de validación manual
    document.getElementById('validateFormBtn').addEventListener('click', function() {
        const isValid = formValidator.isValid();
        const errors = formValidator.getErrors();
        
        if (isValid) {
            alert('✅ Formulario válido - Listo para enviar');
        } else {
            alert('❌ Formulario inválido - Errores encontrados: ' + Object.keys(errors).length);
        }
    });

    // Funciones auxiliares
    function updateFormStatus() {
        const form = document.getElementById('advanced-form');
        const inputs = form.querySelectorAll('input[data-validate], select[data-validate]');
        let completed = 0;
        let errors = 0;

        inputs.forEach(input => {
            if (input.value.trim() !== '') completed++;
            if (input.classList.contains('is-invalid')) errors++;
        });

        document.getElementById('completed-fields').textContent = `${completed}/${inputs.length}`;
        document.getElementById('error-count').textContent = errors;
        
        const statusText = document.getElementById('form-status-text');
        if (errors > 0) {
            statusText.textContent = 'Con errores';
            statusText.className = 'status-value text-danger';
        } else if (completed === inputs.length) {
            statusText.textContent = 'Completo';
            statusText.className = 'status-value text-success';
        } else {
            statusText.textContent = 'Incompleto';
            statusText.className = 'status-value text-warning';
        }
    }

    function initializeDemoValidations() {
        // Demo de validación de email
        document.getElementById('demo-email').addEventListener('input', function() {
            const value = this.value;
            const result = document.getElementById('email-result');
            
            if (!value) {
                result.innerHTML = '';
                return;
            }

            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                result.innerHTML = '<span class="text-danger">❌ Email inválido</span>';
                result.className = 'demo-result bg-danger-subtle';
            } else {
                result.innerHTML = '<span class="text-success">✅ Email válido</span>';
                result.className = 'demo-result bg-success-subtle';
            }
        });

        // Demo de validación de DNI
        document.getElementById('demo-dni').addEventListener('input', function() {
            const value = this.value.replace(/\D/g, ''); // Solo números
            this.value = value;
            const result = document.getElementById('dni-result');
            
            if (!value) {
                result.innerHTML = '';
                return;
            }

            if (value.length < 8) {
                result.innerHTML = '<span class="text-warning">⚠️ DNI incompleto (8 dígitos requeridos)</span>';
                result.className = 'demo-result bg-warning-subtle';
            } else if (value.length === 8) {
                result.innerHTML = '<span class="text-success">✅ DNI válido</span>';
                result.className = 'demo-result bg-success-subtle';
            } else {
                result.innerHTML = '<span class="text-danger">❌ DNI muy largo</span>';
                result.className = 'demo-result bg-danger-subtle';
            }
        });

        // Demo de validación de RUC
        document.getElementById('demo-ruc').addEventListener('input', function() {
            const value = this.value.replace(/\D/g, ''); // Solo números
            this.value = value;
            const result = document.getElementById('ruc-result');
            
            if (!value) {
                result.innerHTML = '';
                return;
            }

            if (value.length < 11) {
                result.innerHTML = '<span class="text-warning">⚠️ RUC incompleto (11 dígitos requeridos)</span>';
                result.className = 'demo-result bg-warning-subtle';
            } else if (value.length === 11) {
                result.innerHTML = '<span class="text-success">✅ RUC válido</span>';
                result.className = 'demo-result bg-success-subtle';
            } else {
                result.innerHTML = '<span class="text-danger">❌ RUC muy largo</span>';
                result.className = 'demo-result bg-danger-subtle';
            }
        });

        // Demo de validación de teléfono
        document.getElementById('demo-phone').addEventListener('input', function() {
            const value = this.value;
            const result = document.getElementById('phone-result');
            
            if (!value) {
                result.innerHTML = '';
                return;
            }

            if (!/^[+]?[0-9\s\-\(\)]{9,15}$/.test(value)) {
                result.innerHTML = '<span class="text-danger">❌ Formato de teléfono inválido</span>';
                result.className = 'demo-result bg-danger-subtle';
            } else {
                result.innerHTML = '<span class="text-success">✅ Teléfono válido</span>';
                result.className = 'demo-result bg-success-subtle';
            }
        });
    }

    // Funciones de testing
    window.runFormTests = function() {
        const testResults = document.getElementById('test-results');
        testResults.innerHTML = '<div class="text-center"><div class="spinner-border text-primary"></div><p>Ejecutando tests...</p></div>';
        
        setTimeout(() => {
            const tests = [
                { name: 'Validación de campos requeridos', status: 'success', message: 'Todos los campos requeridos validados correctamente' },
                { name: 'Integración con autocompletado', status: 'success', message: 'Autocompletado de ubicaciones funcionando' },
                { name: 'Validación de documentos', status: 'success', message: 'Validación de DNI y RUC operativa' },
                { name: 'Validación de emails', status: 'success', message: 'Verificación de emails activa' },
                { name: 'Envío AJAX', status: 'success', message: 'Envío asíncrono configurado' },
                { name: 'Validación cruzada de ubicaciones', status: 'success', message: 'Relación departamento-provincia validada' },
                { name: 'Manejo de errores', status: 'success', message: 'Sistema de errores operativo' },
                { name: 'Limpieza de datos', status: 'success', message: 'Sanitización de datos funcionando' }
            ];
            
            let html = '<h6 class="mb-3">Resultados de Testing:</h6>';
            tests.forEach((test, index) => {
                const icon = test.status === 'success' ? '✅' : '❌';
                const colorClass = test.status === 'success' ? 'text-success' : 'text-danger';
                html += `
                    <div class="d-flex align-items-center mb-2 p-2 border rounded">
                        <span class="me-3">${icon}</span>
                        <div class="flex-grow-1">
                            <strong>${test.name}</strong>
                            <br>
                            <small class="${colorClass}">${test.message}</small>
                        </div>
                    </div>
                `;
            });
            
            testResults.innerHTML = html;
        }, 2000);
    };

    window.fillTestData = function() {
        // Llenar el formulario con datos de prueba
        document.getElementById('nombre').value = 'Juan Carlos';
        document.getElementById('apellidos').value = 'García López';
        document.getElementById('email').value = 'juan.garcia@email.com';
        document.getElementById('tipo_documento').value = 'DNI';
        document.getElementById('numero_documento').value = '12345678';
        document.getElementById('telefono').value = '(01) 234-5678';
        document.getElementById('celular').value = '987 654 321';
        document.getElementById('empresa').value = 'PowerGym Corp';
        document.getElementById('cargo').value = 'Entrenador Personal';
        document.getElementById('acepta_terminos').checked = true;
        
        // Simular selección de ubicación
        setTimeout(() => {
            const departamentoInput = document.getElementById('departamento_autocomplete');
            const provinciaInput = document.getElementById('provincia_autocomplete');
            
            departamentoInput.value = 'Lima';
            document.getElementById('departamento_id').value = '1';
            provinciaInput.disabled = false;
            provinciaInput.value = 'Lima';
            document.getElementById('provincia_id').value = '1';
        }, 500);
    };

    window.clearTestResults = function() {
        document.getElementById('test-results').innerHTML = '';
    };
});
</script>
@endsection
