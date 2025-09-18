/**
 * Enhanced Registration Form Component
 * Integra autocompletado de empresas y selección de ubicaciones
 */
class EnhancedRegistrationForm {
    constructor(options = {}) {
        this.config = {
            formId: options.formId || 'enhanced-registration-form',
            apiBaseUrl: options.apiBaseUrl || '/api/v1',
            enableCompanyAutocomplete: options.enableCompanyAutocomplete !== false,
            enableLocationSelector: options.enableLocationSelector !== false,
            enableRealTimeValidation: options.enableRealTimeValidation !== false,
            submitUrl: options.submitUrl || '/register',
            redirectUrl: options.redirectUrl || '/dashboard',
            fieldMappings: {
                // Usuario
                userName: options.userNameField || 'name',
                userEmail: options.userEmailField || 'email',
                userTelefonoCelular: options.userTelefonoCelularField || 'telefono_celular',
                userTelefonoFijo: options.userTelefonoFijoField || 'telefono_fijo',
                // Empresa
                empresaRuc: options.empresaRucField || 'empresa_ruc',
                empresaRazonSocial: options.empresaRazonSocialField || 'empresa_razon_social',
                empresaTelefonoFijo: options.empresaTelefonoFijoField || 'empresa_telefono_fijo',
                // Ubicación
                departamentoId: options.departamentoIdField || 'departamento_id',
                provinciaId: options.provinciaIdField || 'provincia_id',
                direccionCalle: options.direccionCalleField || 'direccion_calle',
                // Otros
                comentarios: options.comentariosField || 'comentarios',
                aceptaTerminos: options.aceptaTerminosField || 'acepta_terminos'
            }
        };

        this.components = {};
        this.validationRules = {};
        this.isSubmitting = false;

        this.init();
    }

    init() {
        this.initializeComponents();
        this.setupValidationRules();
        this.bindFormEvents();
        this.setupRealTimeValidation();
    }

    initializeComponents() {
        // Inicializar autocompletado de empresas
        if (this.config.enableCompanyAutocomplete) {
            this.components.companyAutocomplete = new CompanyAutocomplete({
                rucInputId: this.config.fieldMappings.empresaRuc,
                razonSocialInputId: this.config.fieldMappings.empresaRazonSocial,
                telefonoInputId: this.config.fieldMappings.empresaTelefonoFijo,
                departamentoInputId: this.config.fieldMappings.departamentoId,
                provinciaInputId: this.config.fieldMappings.provinciaId,
                direccionInputId: this.config.fieldMappings.direccionCalle,
                apiBaseUrl: this.config.apiBaseUrl
            });
        }

        // Inicializar selector de ubicaciones
        if (this.config.enableLocationSelector) {
            this.components.locationSelector = new LocationSelector({
                departamentoSelectId: this.config.fieldMappings.departamentoId,
                provinciaSelectId: this.config.fieldMappings.provinciaId,
                apiBaseUrl: this.config.apiBaseUrl,
                loadOnInit: true
            });
        }
    }

    setupValidationRules() {
        this.validationRules = {
            [this.config.fieldMappings.userName]: {
                required: true,
                minLength: 2,
                maxLength: 255,
                pattern: /^[\pL\s\-]+$/u,
                message: 'El nombre debe contener solo letras, espacios y guiones'
            },
            [this.config.fieldMappings.userEmail]: {
                required: true,
                maxLength: 255,
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: 'Ingrese un email válido'
            },
            [this.config.fieldMappings.userTelefonoCelular]: {
                required: true,
                maxLength: 20,
                pattern: /^[\d\s\-\+\(\)]+$/,
                message: 'El teléfono celular contiene caracteres inválidos'
            },
            [this.config.fieldMappings.empresaRuc]: {
                required: true,
                length: 11,
                pattern: /^[0-9]+$/,
                message: 'El RUC debe tener exactamente 11 dígitos',
                customValidation: 'validateRuc'
            },
            [this.config.fieldMappings.empresaRazonSocial]: {
                required: true,
                minLength: 5,
                maxLength: 255,
                message: 'La razón social debe tener entre 5 y 255 caracteres'
            },
            [this.config.fieldMappings.departamentoId]: {
                required: true,
                message: 'Seleccione un departamento'
            },
            [this.config.fieldMappings.provinciaId]: {
                required: true,
                message: 'Seleccione una provincia'
            },
            [this.config.fieldMappings.direccionCalle]: {
                required: true,
                minLength: 10,
                maxLength: 500,
                message: 'La dirección debe tener entre 10 y 500 caracteres'
            },
            [this.config.fieldMappings.aceptaTerminos]: {
                required: true,
                checked: true,
                message: 'Debe aceptar los términos y condiciones'
            }
        };
    }

    bindFormEvents() {
        const form = document.getElementById(this.config.formId);
        if (!form) {
            console.error(`Form with ID ${this.config.formId} not found`);
            return;
        }

        // Evento de submit del formulario
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleFormSubmit(e);
        });

        // Eventos de los componentes
        if (this.components.locationSelector) {
            this.components.locationSelector.on('departamentoChanged', (e) => {
                this.clearValidationError(this.config.fieldMappings.provinciaId);
            });
        }
    }

    setupRealTimeValidation() {
        if (!this.config.enableRealTimeValidation) return;

        Object.keys(this.validationRules).forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field) {
                // Validación en blur
                field.addEventListener('blur', () => {
                    this.validateField(fieldName);
                });

                // Validación en input para algunos campos específicos
                if (['empresaRuc', 'userEmail'].includes(fieldName.replace(this.config.fieldMappings, ''))) {
                    let inputTimeout;
                    field.addEventListener('input', () => {
                        clearTimeout(inputTimeout);
                        inputTimeout = setTimeout(() => {
                            this.validateField(fieldName);
                        }, 500);
                    });
                }
            }
        });
    }

    async validateField(fieldName) {
        const field = document.getElementById(fieldName);
        if (!field) return false;

        const rule = this.validationRules[fieldName];
        if (!rule) return true;

        const value = field.type === 'checkbox' ? field.checked : field.value.trim();

        // Validación requerida
        if (rule.required && !value) {
            this.showValidationError(fieldName, rule.message || 'Este campo es requerido');
            return false;
        }

        // Si el campo está vacío y no es requerido, es válido
        if (!value && !rule.required) {
            this.clearValidationError(fieldName);
            return true;
        }

        // Validación de longitud mínima
        if (rule.minLength && value.length < rule.minLength) {
            this.showValidationError(fieldName, `Debe tener al menos ${rule.minLength} caracteres`);
            return false;
        }

        // Validación de longitud máxima
        if (rule.maxLength && value.length > rule.maxLength) {
            this.showValidationError(fieldName, `No debe exceder ${rule.maxLength} caracteres`);
            return false;
        }

        // Validación de longitud exacta
        if (rule.length && value.length !== rule.length) {
            this.showValidationError(fieldName, `Debe tener exactamente ${rule.length} caracteres`);
            return false;
        }

        // Validación de patrón
        if (rule.pattern && !rule.pattern.test(value)) {
            this.showValidationError(fieldName, rule.message || 'Formato inválido');
            return false;
        }

        // Validación de checkbox
        if (rule.checked && !value) {
            this.showValidationError(fieldName, rule.message || 'Debe estar marcado');
            return false;
        }

        // Validación personalizada
        if (rule.customValidation) {
            const isValid = await this.runCustomValidation(rule.customValidation, value, fieldName);
            if (!isValid) {
                return false;
            }
        }

        this.clearValidationError(fieldName);
        return true;
    }

    async runCustomValidation(validationType, value, fieldName) {
        switch (validationType) {
            case 'validateRuc':
                if (this.components.companyAutocomplete) {
                    const isValid = await this.components.companyAutocomplete.validateRuc(value);
                    if (!isValid) {
                        this.showValidationError(fieldName, 'El RUC ingresado no es válido');
                        return false;
                    }
                }
                break;
            default:
                console.warn(`Unknown custom validation: ${validationType}`);
        }
        return true;
    }

    async validateForm() {
        const validationPromises = Object.keys(this.validationRules).map(fieldName => 
            this.validateField(fieldName)
        );

        const results = await Promise.all(validationPromises);
        return results.every(result => result === true);
    }

    async handleFormSubmit(event) {
        if (this.isSubmitting) {
            return;
        }

        try {
            this.setSubmitting(true);

            // Validar formulario
            const isValid = await this.validateForm();
            if (!isValid) {
                this.showError('Por favor corrija los errores en el formulario');
                return;
            }

            // Recopilar datos del formulario
            const formData = this.collectFormData();

            // Enviar datos
            const response = await this.submitFormData(formData);

            if (response.success) {
                this.showSuccess('Registro completado exitosamente');
                
                // Redirigir después de un breve delay
                setTimeout(() => {
                    window.location.href = this.config.redirectUrl;
                }, 1500);
            } else {
                this.handleSubmissionError(response);
            }

        } catch (error) {
            console.error('Form submission error:', error);
            this.showError('Error al procesar el registro. Por favor intente nuevamente.');
        } finally {
            this.setSubmitting(false);
        }
    }

    collectFormData() {
        const form = document.getElementById(this.config.formId);
        const formData = new FormData(form);
        const data = {};

        // Convertir FormData a objeto plano
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        // Agregar datos adicionales de ubicación
        if (this.components.locationSelector) {
            const locationData = this.components.locationSelector.getSelectedLocationData();
            if (locationData.departamento) {
                data.departamento_info = {
                    id: locationData.departamento.id,
                    nombre: locationData.departamento.nombre,
                    codigo: locationData.departamento.codigo
                };
            }
            if (locationData.provincia) {
                data.provincia_info = {
                    id: locationData.provincia.id,
                    nombre: locationData.provincia.nombre,
                    codigo: locationData.provincia.codigo
                };
            }
        }

        return data;
    }

    async submitFormData(data) {
        const response = await fetch(this.config.submitUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                // Agregar CSRF token si está disponible
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    }

    handleSubmissionError(response) {
        if (response.errors) {
            // Mostrar errores de validación específicos
            Object.keys(response.errors).forEach(fieldName => {
                const errors = response.errors[fieldName];
                if (Array.isArray(errors) && errors.length > 0) {
                    this.showValidationError(fieldName, errors[0]);
                }
            });
        } else {
            this.showError(response.message || 'Error al procesar el registro');
        }
    }

    showValidationError(fieldName, message) {
        const field = document.getElementById(fieldName);
        if (!field) return;

        // Remover error previo
        this.clearValidationError(fieldName);

        // Agregar clase de error al campo
        field.classList.add('is-invalid');

        // Crear elemento de error
        const errorElement = document.createElement('div');
        errorElement.className = 'invalid-feedback';
        errorElement.id = `${fieldName}-error`;
        errorElement.textContent = message;
        errorElement.style.cssText = `
            display: block;
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        `;

        // Insertar después del campo
        field.parentNode.appendChild(errorElement);
    }

    clearValidationError(fieldName) {
        const field = document.getElementById(fieldName);
        if (field) {
            field.classList.remove('is-invalid');
        }

        const errorElement = document.getElementById(`${fieldName}-error`);
        if (errorElement) {
            errorElement.remove();
        }
    }

    setSubmitting(submitting) {
        this.isSubmitting = submitting;
        
        const form = document.getElementById(this.config.formId);
        const submitButton = form?.querySelector('button[type="submit"], input[type="submit"]');
        
        if (submitButton) {
            submitButton.disabled = submitting;
            
            if (submitting) {
                submitButton.dataset.originalText = submitButton.textContent;
                submitButton.textContent = 'Procesando...';
                submitButton.style.opacity = '0.6';
            } else {
                submitButton.textContent = submitButton.dataset.originalText || 'Registrarse';
                submitButton.style.opacity = '1';
            }
        }

        // Deshabilitar todos los campos durante el envío
        const formElements = form?.querySelectorAll('input, select, textarea');
        formElements?.forEach(element => {
            element.disabled = submitting;
        });
    }

    showSuccess(message) {
        this.showMessage(message, 'success');
    }

    showError(message) {
        this.showMessage(message, 'error');
    }

    showMessage(message, type = 'info') {
        // Reutilizar sistema de mensajes existente
        if (this.components.companyAutocomplete) {
            this.components.companyAutocomplete.showMessage(message, type);
        } else {
            // Sistema básico de fallback
            alert(message);
        }
    }

    // Métodos públicos
    reset() {
        const form = document.getElementById(this.config.formId);
        if (form) {
            form.reset();
        }

        if (this.components.companyAutocomplete) {
            this.components.companyAutocomplete.clear();
        }

        if (this.components.locationSelector) {
            this.components.locationSelector.reset();
        }

        // Limpiar errores de validación
        Object.keys(this.validationRules).forEach(fieldName => {
            this.clearValidationError(fieldName);
        });
    }

    destroy() {
        Object.values(this.components).forEach(component => {
            if (component.destroy) {
                component.destroy();
            }
        });
        
        this.components = {};
    }

    // Getters para acceder a los componentes
    getCompanyAutocomplete() {
        return this.components.companyAutocomplete;
    }

    getLocationSelector() {
        return this.components.locationSelector;
    }
}

// Exportar para uso global
window.EnhancedRegistrationForm = EnhancedRegistrationForm;
