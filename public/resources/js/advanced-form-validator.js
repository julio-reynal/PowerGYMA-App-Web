/**
 * Advanced Form Validator with Location Integration
 * FASE 5: FORMULARIOS Y VALIDACIONES
 * Sistema de validación completo para formularios con ubicaciones
 */
class AdvancedFormValidator {
    constructor(options = {}) {
        this.config = {
            // Elemento del formulario
            formSelector: options.formSelector || '#advanced-form',
            
            // Configuración de validación
            validateOnInput: options.validateOnInput !== false,
            validateOnBlur: options.validateOnBlur !== false,
            showSuccessMessages: options.showSuccessMessages !== false,
            
            // Reglas de validación personalizadas
            customRules: options.customRules || {},
            
            // Configuración de autocompletado
            locationConfig: {
                departamentoInputId: options.departamentoInputId || 'departamento_autocomplete',
                provinciaInputId: options.provinciaInputId || 'provincia_autocomplete',
                departamentoHiddenId: options.departamentoHiddenId || 'departamento_id',
                provinciaHiddenId: options.provinciaHiddenId || 'provincia_id',
                requireLocation: options.requireLocation !== false
            },
            
            // Callbacks
            onValidation: options.onValidation || null,
            onSubmit: options.onSubmit || null,
            onError: options.onError || null,
            onSuccess: options.onSuccess || null
        };

        // Estado del validador
        this.state = {
            isValid: false,
            errors: {},
            touched: {},
            isSubmitting: false,
            locationData: {
                department: null,
                province: null
            }
        };

        // Reglas de validación
        this.validationRules = {
            required: (value) => value && value.toString().trim().length > 0,
            email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            minLength: (value, length) => value && value.length >= length,
            maxLength: (value, length) => value && value.length <= length,
            numeric: (value) => /^\d+$/.test(value),
            alphanumeric: (value) => /^[a-zA-Z0-9]+$/.test(value),
            phone: (value) => /^[+]?[0-9\s\-\(\)]{9,15}$/.test(value),
            url: (value) => /^https?:\/\/.+\..+/.test(value),
            strongPassword: (value) => {
                // Al menos 8 caracteres, una mayúscula, una minúscula, un número
                return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]{8,}$/.test(value);
            },
            ruc: (value) => {
                // Validación básica de RUC peruano (11 dígitos)
                return /^\d{11}$/.test(value);
            },
            dni: (value) => {
                // Validación básica de DNI peruano (8 dígitos)
                return /^\d{8}$/.test(value);
            },
            ...this.config.customRules
        };

        // Mensajes de error
        this.errorMessages = {
            required: 'Este campo es obligatorio',
            email: 'Ingrese un email válido',
            minLength: 'Debe tener al menos {length} caracteres',
            maxLength: 'No puede tener más de {length} caracteres',
            numeric: 'Solo se permiten números',
            alphanumeric: 'Solo se permiten letras y números',
            phone: 'Ingrese un número de teléfono válido',
            url: 'Ingrese una URL válida',
            strongPassword: 'Debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número',
            ruc: 'Ingrese un RUC válido de 11 dígitos',
            dni: 'Ingrese un DNI válido de 8 dígitos',
            locationRequired: 'Debe seleccionar departamento y provincia',
            match: 'Los campos no coinciden'
        };

        // Referencias DOM
        this.form = null;
        this.locationAutocomplete = null;

        this.init();
    }

    async init() {
        try {
            this.initializeForm();
            this.setupLocationIntegration();
            this.bindEvents();
            this.setupRealTimeValidation();
            
            this.log('✅ AdvancedFormValidator inicializado correctamente');
        } catch (error) {
            this.handleError('Error inicializando el validador de formularios', error);
        }
    }

    initializeForm() {
        this.form = document.querySelector(this.config.formSelector);
        if (!this.form) {
            throw new Error(`Formulario no encontrado: ${this.config.formSelector}`);
        }

        // Agregar clases CSS para styling
        this.form.classList.add('advanced-form');
        this.form.noValidate = true; // Deshabilitar validación HTML5 nativa

        // Crear contenedor para mensajes globales
        this.createGlobalMessageContainer();
    }

    async setupLocationIntegration() {
        // Integrar con el sistema de autocompletado si está disponible
        if (window.AdvancedLocationAutocomplete) {
            this.locationAutocomplete = new window.AdvancedLocationAutocomplete({
                ...this.config.locationConfig,
                onDepartmentSelect: (department) => {
                    this.state.locationData.department = department;
                    this.validateField('location');
                    this.log('📍 Departamento seleccionado:', department.nombre);
                },
                onProvinceSelect: (province) => {
                    this.state.locationData.province = province;
                    this.validateField('location');
                    this.log('🏘️ Provincia seleccionada:', province.nombre);
                },
                onClear: () => {
                    this.state.locationData = { department: null, province: null };
                    this.validateField('location');
                }
            });
        }
    }

    bindEvents() {
        // Evento de envío del formulario
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSubmit();
        });

        // Eventos para validación en tiempo real
        if (this.config.validateOnInput) {
            this.form.addEventListener('input', (e) => {
                if (this.state.touched[e.target.name]) {
                    this.validateField(e.target.name);
                }
            });
        }

        if (this.config.validateOnBlur) {
            this.form.addEventListener('blur', (e) => {
                if (e.target.name) {
                    this.state.touched[e.target.name] = true;
                    this.validateField(e.target.name);
                }
            }, true);
        }

        // Evento de reset
        this.form.addEventListener('reset', () => {
            this.resetForm();
        });
    }

    setupRealTimeValidation() {
        // Configurar validación para campos específicos
        const fields = this.form.querySelectorAll('[data-validate]');
        
        fields.forEach(field => {
            // Agregar eventos específicos según el tipo de campo
            const fieldType = field.type;
            
            if (fieldType === 'email') {
                field.addEventListener('input', this.debounce(() => {
                    this.validateField(field.name);
                }, 500));
            }
            
            if (field.dataset.validate.includes('strongPassword')) {
                field.addEventListener('input', () => {
                    this.validatePasswordStrength(field);
                });
            }
        });
    }

    validateField(fieldName) {
        if (fieldName === 'location') {
            return this.validateLocation();
        }

        const field = this.form.querySelector(`[name="${fieldName}"]`);
        if (!field) return true;

        const value = field.value;
        const rules = field.dataset.validate?.split('|') || [];
        const errors = [];

        // Validar cada regla
        for (const rule of rules) {
            const [ruleName, ...params] = rule.split(':');
            const param = params.join(':'); // Para casos como minLength:8

            if (!this.validationRules[ruleName]) {
                console.warn(`Regla de validación desconocida: ${ruleName}`);
                continue;
            }

            let isValid;
            if (param) {
                isValid = this.validationRules[ruleName](value, param);
            } else {
                isValid = this.validationRules[ruleName](value);
            }

            if (!isValid) {
                let message = this.errorMessages[ruleName] || `Error en ${ruleName}`;
                message = message.replace('{length}', param);
                errors.push(message);
            }
        }

        // Validaciones especiales
        if (field.dataset.match) {
            const matchField = this.form.querySelector(`[name="${field.dataset.match}"]`);
            if (matchField && field.value !== matchField.value) {
                errors.push(this.errorMessages.match);
            }
        }

        // Actualizar estado
        if (errors.length > 0) {
            this.state.errors[fieldName] = errors;
            this.showFieldError(field, errors[0]);
            return false;
        } else {
            delete this.state.errors[fieldName];
            this.showFieldSuccess(field);
            return true;
        }
    }

    validateLocation() {
        if (!this.config.locationConfig.requireLocation) return true;

        const hasValidLocation = 
            this.state.locationData.department && 
            this.state.locationData.province;

        if (!hasValidLocation) {
            this.state.errors.location = [this.errorMessages.locationRequired];
            this.showLocationError();
            return false;
        } else {
            delete this.state.errors.location;
            this.showLocationSuccess();
            return true;
        }
    }

    validatePasswordStrength(field) {
        const value = field.value;
        const strengthIndicator = this.getPasswordStrengthIndicator(field);
        
        const checks = {
            length: value.length >= 8,
            uppercase: /[A-Z]/.test(value),
            lowercase: /[a-z]/.test(value),
            number: /\d/.test(value),
            special: /[@$!%*?&]/.test(value)
        };

        const score = Object.values(checks).filter(Boolean).length;
        const strength = ['Muy débil', 'Débil', 'Regular', 'Buena', 'Excelente'][score];
        const colors = ['#dc3545', '#fd7e14', '#ffc107', '#28a745', '#17a2b8'];

        strengthIndicator.textContent = `Fortaleza: ${strength}`;
        strengthIndicator.style.color = colors[score];
        
        return score >= 4; // Requiere al menos 4 criterios
    }

    getPasswordStrengthIndicator(field) {
        let indicator = field.parentNode.querySelector('.password-strength');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.className = 'password-strength';
            indicator.style.cssText = 'font-size: 12px; margin-top: 5px;';
            field.parentNode.appendChild(indicator);
        }
        return indicator;
    }

    validateForm() {
        const fields = this.form.querySelectorAll('[data-validate]');
        let isValid = true;

        // Validar todos los campos
        fields.forEach(field => {
            if (!this.validateField(field.name)) {
                isValid = false;
            }
        });

        // Validar ubicación si es requerida
        if (!this.validateLocation()) {
            isValid = false;
        }

        this.state.isValid = isValid;
        return isValid;
    }

    async handleSubmit() {
        if (this.state.isSubmitting) return;

        this.state.isSubmitting = true;
        this.showSubmittingState();

        try {
            // Validar formulario completo
            const isValid = this.validateForm();

            if (!isValid) {
                this.showGlobalError('Por favor, corrija los errores antes de continuar');
                this.focusFirstError();
                return;
            }

            // Recopilar datos del formulario
            const formData = this.collectFormData();

            // Callback de validación personalizada
            if (this.config.onValidation) {
                const customValid = await this.config.onValidation(formData);
                if (!customValid) {
                    this.showGlobalError('Error en validación personalizada');
                    return;
                }
            }

            // Enviar formulario
            if (this.config.onSubmit) {
                const result = await this.config.onSubmit(formData);
                if (result && result.success) {
                    this.showGlobalSuccess('Formulario enviado exitosamente');
                    if (this.config.onSuccess) {
                        this.config.onSuccess(result);
                    }
                } else {
                    this.showGlobalError(result?.message || 'Error al enviar el formulario');
                }
            } else {
                // Envío estándar por POST
                await this.submitStandardForm(formData);
            }

        } catch (error) {
            this.handleError('Error al procesar el formulario', error);
        } finally {
            this.state.isSubmitting = false;
            this.hideSubmittingState();
        }
    }

    collectFormData() {
        const formData = new FormData(this.form);
        const data = {};

        // Convertir FormData a objeto
        for (const [key, value] of formData.entries()) {
            data[key] = value;
        }

        // Agregar datos de ubicación
        if (this.state.locationData.department) {
            data.departamento_id = this.state.locationData.department.id;
            data.departamento_nombre = this.state.locationData.department.nombre;
        }

        if (this.state.locationData.province) {
            data.provincia_id = this.state.locationData.province.id;
            data.provincia_nombre = this.state.locationData.province.nombre;
        }

        // Agregar metadatos
        data._token = document.querySelector('meta[name="csrf-token"]')?.content;
        data._timestamp = new Date().toISOString();
        data._validation_level = 'advanced';

        return data;
    }

    async submitStandardForm(data) {
        const response = await fetch(this.form.action || window.location.href, {
            method: this.form.method || 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': data._token
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const result = await response.json();
        
        if (result.success) {
            this.showGlobalSuccess(result.message || 'Formulario enviado exitosamente');
        } else {
            this.showGlobalError(result.message || 'Error al procesar el formulario');
        }

        return result;
    }

    showFieldError(field, message) {
        this.removeFieldMessages(field);
        
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');

        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        
        field.parentNode.appendChild(errorDiv);
    }

    showFieldSuccess(field) {
        if (!this.config.showSuccessMessages) return;

        this.removeFieldMessages(field);
        
        field.classList.add('is-valid');
        field.classList.remove('is-invalid');

        const successDiv = document.createElement('div');
        successDiv.className = 'valid-feedback';
        successDiv.textContent = '✓ Válido';
        
        field.parentNode.appendChild(successDiv);
    }

    removeFieldMessages(field) {
        const parent = field.parentNode;
        const feedback = parent.querySelectorAll('.invalid-feedback, .valid-feedback');
        feedback.forEach(el => el.remove());
    }

    showLocationError() {
        const container = this.getLocationContainer();
        if (container) {
            container.classList.add('location-error');
            
            let errorEl = container.querySelector('.location-error-message');
            if (!errorEl) {
                errorEl = document.createElement('div');
                errorEl.className = 'location-error-message invalid-feedback';
                errorEl.style.display = 'block';
                container.appendChild(errorEl);
            }
            errorEl.textContent = this.errorMessages.locationRequired;
        }
    }

    showLocationSuccess() {
        const container = this.getLocationContainer();
        if (container) {
            container.classList.remove('location-error');
            const errorEl = container.querySelector('.location-error-message');
            if (errorEl) {
                errorEl.remove();
            }
        }
    }

    getLocationContainer() {
        return document.querySelector('.location-fields-container') || 
               document.querySelector(`#${this.config.locationConfig.departamentoInputId}`)?.closest('.form-group');
    }

    createGlobalMessageContainer() {
        let container = this.form.querySelector('.global-messages');
        if (!container) {
            container = document.createElement('div');
            container.className = 'global-messages';
            container.style.cssText = 'margin-bottom: 20px;';
            this.form.insertBefore(container, this.form.firstChild);
        }
        return container;
    }

    showGlobalError(message) {
        this.showGlobalMessage(message, 'error');
    }

    showGlobalSuccess(message) {
        this.showGlobalMessage(message, 'success');
    }

    showGlobalMessage(message, type) {
        const container = this.createGlobalMessageContainer();
        
        container.innerHTML = `
            <div class="alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show">
                <strong>${type === 'error' ? '❌' : '✅'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // Auto-dismiss success messages
        if (type === 'success') {
            setTimeout(() => {
                const alert = container.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            }, 5000);
        }
    }

    showSubmittingState() {
        const submitBtn = this.form.querySelector('[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.dataset.originalText = submitBtn.textContent;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';
        }
    }

    hideSubmittingState() {
        const submitBtn = this.form.querySelector('[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = submitBtn.dataset.originalText || 'Enviar';
        }
    }

    focusFirstError() {
        const firstError = this.form.querySelector('.is-invalid, .location-error input');
        if (firstError) {
            firstError.focus();
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    resetForm() {
        // Limpiar estado
        this.state.isValid = false;
        this.state.errors = {};
        this.state.touched = {};
        this.state.locationData = { department: null, province: null };

        // Limpiar clases y mensajes
        const fields = this.form.querySelectorAll('.is-invalid, .is-valid');
        fields.forEach(field => {
            field.classList.remove('is-invalid', 'is-valid');
        });

        const feedback = this.form.querySelectorAll('.invalid-feedback, .valid-feedback');
        feedback.forEach(el => el.remove());

        // Limpiar mensajes globales
        const globalMessages = this.form.querySelector('.global-messages');
        if (globalMessages) {
            globalMessages.innerHTML = '';
        }

        // Resetear autocompletado de ubicación
        if (this.locationAutocomplete) {
            this.locationAutocomplete.reset();
        }
    }

    // Métodos públicos
    isValid() {
        return this.validateForm();
    }

    getErrors() {
        return this.state.errors;
    }

    getFormData() {
        return this.collectFormData();
    }

    setFieldValue(fieldName, value) {
        const field = this.form.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.value = value;
            this.validateField(fieldName);
        }
    }

    addCustomRule(name, validator, message) {
        this.validationRules[name] = validator;
        this.errorMessages[name] = message;
    }

    // Utilidades
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    handleError(message, error) {
        this.log(`❌ ${message}:`, error);
        
        if (this.config.onError) {
            this.config.onError(message, error);
        } else {
            this.showGlobalError(`${message}: ${error.message}`);
        }
    }

    log(...args) {
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            console.log('[AdvancedFormValidator]', ...args);
        }
    }

    destroy() {
        // Limpiar eventos y referencias
        if (this.locationAutocomplete) {
            this.locationAutocomplete.destroy();
        }
    }
}

// Exportar para uso global
window.AdvancedFormValidator = AdvancedFormValidator;
