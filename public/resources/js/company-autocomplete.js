/**
 * Company Autocomplete Component
 * Maneja el autocompletado de empresas por RUC y razón social
 */
class CompanyAutocomplete {
    constructor(options = {}) {
        this.config = {
            rucInputId: options.rucInputId || 'empresa_ruc',
            razonSocialInputId: options.razonSocialInputId || 'empresa_razon_social',
            telefonoInputId: options.telefonoInputId || 'empresa_telefono_fijo',
            departamentoInputId: options.departamentoInputId || 'departamento_id',
            provinciaInputId: options.provinciaInputId || 'provincia_id',
            direccionInputId: options.direccionInputId || 'direccion_calle',
            suggestionContainerId: options.suggestionContainerId || 'company-suggestions',
            apiBaseUrl: options.apiBaseUrl || '/api/v1',
            minQueryLength: options.minQueryLength || 2,
            debounceDelay: options.debounceDelay || 300,
            maxSuggestions: options.maxSuggestions || 5
        };

        this.debounceTimer = null;
        this.currentRequest = null;
        this.isLoading = false;

        this.init();
    }

    init() {
        this.createSuggestionContainer();
        this.bindEvents();
        this.setInitialState();
    }

    createSuggestionContainer() {
        // Crear contenedor de sugerencias si no existe
        if (!document.getElementById(this.config.suggestionContainerId)) {
            const container = document.createElement('div');
            container.id = this.config.suggestionContainerId;
            container.className = 'autocomplete-suggestions';
            container.style.cssText = `
                position: absolute;
                z-index: 1000;
                background: white;
                border: 1px solid #ddd;
                border-radius: 4px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                max-height: 200px;
                overflow-y: auto;
                display: none;
                width: 100%;
                margin-top: 2px;
            `;

            // Insertar después del input de RUC
            const rucInput = document.getElementById(this.config.rucInputId);
            if (rucInput) {
                rucInput.parentNode.style.position = 'relative';
                rucInput.parentNode.appendChild(container);
            }
        }
    }

    bindEvents() {
        const rucInput = document.getElementById(this.config.rucInputId);
        const razonSocialInput = document.getElementById(this.config.razonSocialInputId);

        if (rucInput) {
            // Evento de input en RUC
            rucInput.addEventListener('input', (e) => {
                this.handleRucInput(e.target.value);
            });

            // Evento de blur para ocultar sugerencias
            rucInput.addEventListener('blur', () => {
                setTimeout(() => this.hideSuggestions(), 150);
            });

            // Evento de focus para mostrar sugerencias si hay query
            rucInput.addEventListener('focus', () => {
                if (rucInput.value.length >= this.config.minQueryLength) {
                    this.showSuggestions();
                }
            });
        }

        if (razonSocialInput) {
            // Evento de input en razón social
            razonSocialInput.addEventListener('input', (e) => {
                this.handleRazonSocialInput(e.target.value);
            });

            razonSocialInput.addEventListener('blur', () => {
                setTimeout(() => this.hideSuggestions(), 150);
            });
        }

        // Cerrar sugerencias al hacer click fuera
        document.addEventListener('click', (e) => {
            const container = document.getElementById(this.config.suggestionContainerId);
            if (container && !container.contains(e.target) && 
                e.target.id !== this.config.rucInputId && 
                e.target.id !== this.config.razonSocialInputId) {
                this.hideSuggestions();
            }
        });
    }

    setInitialState() {
        // Limpiar campos relacionados al iniciar
        this.clearCompanyFields();
    }

    handleRucInput(ruc) {
        // Limpiar el RUC (solo números)
        const cleanRuc = ruc.replace(/[^0-9]/g, '');
        
        // Actualizar el input con el RUC limpio
        const rucInput = document.getElementById(this.config.rucInputId);
        if (rucInput && rucInput.value !== cleanRuc) {
            rucInput.value = cleanRuc;
        }

        // Validar longitud
        if (cleanRuc.length < 8) {
            this.hideSuggestions();
            this.clearCompanyFields();
            return;
        }

        // Si tiene 11 dígitos, buscar empresa específica
        if (cleanRuc.length === 11) {
            this.searchCompanyByRuc(cleanRuc);
        } else {
            // Si tiene entre 8-10 dígitos, buscar sugerencias
            this.debounceSearch(() => this.searchSuggestions(cleanRuc));
        }
    }

    handleRazonSocialInput(razonSocial) {
        if (razonSocial.length < this.config.minQueryLength) {
            this.hideSuggestions();
            return;
        }

        this.debounceSearch(() => this.searchSuggestions(razonSocial));
    }

    debounceSearch(callback) {
        clearTimeout(this.debounceTimer);
        this.debounceTimer = setTimeout(callback, this.config.debounceDelay);
    }

    async searchCompanyByRuc(ruc) {
        try {
            this.setLoading(true);
            
            const response = await this.makeRequest(`${this.config.apiBaseUrl}/companies/ruc/${ruc}`);
            
            if (response.success && response.data) {
                this.populateCompanyData(response.data);
                this.hideSuggestions();
                this.showSuccess('Empresa encontrada y cargada automáticamente');
            } else {
                this.clearCompanyFields();
                this.showError('Empresa no encontrada con este RUC');
            }
        } catch (error) {
            console.error('Error searching company by RUC:', error);
            this.clearCompanyFields();
            this.showError('Error al buscar la empresa');
        } finally {
            this.setLoading(false);
        }
    }

    async searchSuggestions(query) {
        try {
            this.setLoading(true);
            
            const endpoint = query.match(/^\d+$/) ? 
                `${this.config.apiBaseUrl}/companies/suggestions?query=${encodeURIComponent(query)}` :
                `${this.config.apiBaseUrl}/companies/search?query=${encodeURIComponent(query)}&limit=${this.config.maxSuggestions}`;
            
            const response = await this.makeRequest(endpoint);
            
            if (response.success && response.data) {
                this.displaySuggestions(response.data);
            } else {
                this.hideSuggestions();
            }
        } catch (error) {
            console.error('Error searching suggestions:', error);
            this.hideSuggestions();
        } finally {
            this.setLoading(false);
        }
    }

    async makeRequest(url) {
        // Cancelar request anterior si existe
        if (this.currentRequest) {
            this.currentRequest.abort();
        }

        this.currentRequest = new AbortController();
        
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            signal: this.currentRequest.signal
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    }

    displaySuggestions(suggestions) {
        const container = document.getElementById(this.config.suggestionContainerId);
        if (!container || !suggestions || suggestions.length === 0) {
            this.hideSuggestions();
            return;
        }

        container.innerHTML = '';

        suggestions.forEach((suggestion, index) => {
            const item = document.createElement('div');
            item.className = 'autocomplete-item';
            item.style.cssText = `
                padding: 10px;
                cursor: pointer;
                border-bottom: 1px solid #eee;
                transition: background-color 0.2s;
            `;

            // Determinar el contenido basado en el tipo de sugerencia
            let content = '';
            if (suggestion.ruc) {
                content = `
                    <div style="font-weight: bold; color: #333;">${suggestion.razon_social || 'Empresa'}</div>
                    <div style="font-size: 0.9em; color: #666;">RUC: ${this.formatRuc(suggestion.ruc)}</div>
                    ${suggestion.telefono_fijo ? `<div style="font-size: 0.8em; color: #999;">Tel: ${suggestion.telefono_fijo}</div>` : ''}
                `;
            } else {
                content = `<div style="color: #333;">${suggestion.text || suggestion}</div>`;
            }

            item.innerHTML = content;

            // Eventos
            item.addEventListener('mouseenter', () => {
                item.style.backgroundColor = '#f5f5f5';
            });

            item.addEventListener('mouseleave', () => {
                item.style.backgroundColor = 'white';
            });

            item.addEventListener('click', () => {
                this.selectSuggestion(suggestion);
            });

            container.appendChild(item);
        });

        this.showSuggestions();
    }

    selectSuggestion(suggestion) {
        if (suggestion.ruc) {
            // Es una empresa completa
            this.populateCompanyData(suggestion);
            this.showSuccess('Empresa seleccionada');
        } else {
            // Es solo una sugerencia de texto
            const razonSocialInput = document.getElementById(this.config.razonSocialInputId);
            if (razonSocialInput) {
                razonSocialInput.value = suggestion.text || suggestion;
            }
        }

        this.hideSuggestions();
    }

    populateCompanyData(companyData) {
        // Rellenar RUC
        const rucInput = document.getElementById(this.config.rucInputId);
        if (rucInput && companyData.ruc) {
            rucInput.value = companyData.ruc;
        }

        // Rellenar razón social
        const razonSocialInput = document.getElementById(this.config.razonSocialInputId);
        if (razonSocialInput && companyData.razon_social) {
            razonSocialInput.value = companyData.razon_social;
        }

        // Rellenar teléfono
        const telefonoInput = document.getElementById(this.config.telefonoInputId);
        if (telefonoInput && companyData.telefono_fijo) {
            telefonoInput.value = companyData.telefono_fijo;
        }

        // Rellenar ubicación si está disponible
        if (companyData.departamento_id) {
            const departamentoSelect = document.getElementById(this.config.departamentoInputId);
            if (departamentoSelect) {
                departamentoSelect.value = companyData.departamento_id;
                // Disparar evento change para cargar provincias
                departamentoSelect.dispatchEvent(new Event('change'));
                
                // Esperar un poco y seleccionar la provincia
                if (companyData.provincia_id) {
                    setTimeout(() => {
                        const provinciaSelect = document.getElementById(this.config.provinciaInputId);
                        if (provinciaSelect) {
                            provinciaSelect.value = companyData.provincia_id;
                        }
                    }, 500);
                }
            }
        }

        // Rellenar dirección
        const direccionInput = document.getElementById(this.config.direccionInputId);
        if (direccionInput && companyData.direccion_calle) {
            direccionInput.value = companyData.direccion_calle;
        }
    }

    clearCompanyFields() {
        const fields = [
            this.config.razonSocialInputId,
            this.config.telefonoInputId,
            this.config.direccionInputId
        ];

        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.value = '';
            }
        });

        // No limpiar departamento y provincia aquí ya que pueden ser independientes
    }

    showSuggestions() {
        const container = document.getElementById(this.config.suggestionContainerId);
        if (container) {
            container.style.display = 'block';
        }
    }

    hideSuggestions() {
        const container = document.getElementById(this.config.suggestionContainerId);
        if (container) {
            container.style.display = 'none';
        }
    }

    setLoading(loading) {
        this.isLoading = loading;
        const rucInput = document.getElementById(this.config.rucInputId);
        
        if (rucInput) {
            if (loading) {
                rucInput.style.backgroundImage = 'url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'20\' height=\'20\' viewBox=\'0 0 20 20\'%3E%3Cpath fill=\'%23999\' d=\'M10 3.5a6.5 6.5 0 100 13 6.5 6.5 0 000-13zm0 11a4.5 4.5 0 110-9 4.5 4.5 0 010 9z\'/%3E%3C/svg%3E")';
                rucInput.style.backgroundRepeat = 'no-repeat';
                rucInput.style.backgroundPosition = 'right 10px center';
                rucInput.style.backgroundSize = '16px';
            } else {
                rucInput.style.backgroundImage = 'none';
            }
        }
    }

    formatRuc(ruc) {
        if (!ruc || ruc.length !== 11) return ruc;
        return ruc.substring(0, 2) + '-' + ruc.substring(2);
    }

    showSuccess(message) {
        this.showMessage(message, 'success');
    }

    showError(message) {
        this.showMessage(message, 'error');
    }

    showMessage(message, type = 'info') {
        // Crear o actualizar mensaje
        let messageEl = document.getElementById('company-autocomplete-message');
        
        if (!messageEl) {
            messageEl = document.createElement('div');
            messageEl.id = 'company-autocomplete-message';
            messageEl.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 10px 15px;
                border-radius: 4px;
                z-index: 9999;
                max-width: 300px;
                font-size: 14px;
                transition: all 0.3s ease;
            `;
            document.body.appendChild(messageEl);
        }

        // Aplicar estilos según el tipo
        const styles = {
            success: 'background: #d4edda; color: #155724; border: 1px solid #c3e6cb;',
            error: 'background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;',
            info: 'background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb;'
        };

        messageEl.style.cssText += styles[type] || styles.info;
        messageEl.textContent = message;

        // Auto ocultar después de 3 segundos
        setTimeout(() => {
            if (messageEl && messageEl.parentNode) {
                messageEl.remove();
            }
        }, 3000);
    }

    // Método público para validar RUC
    async validateRuc(ruc) {
        try {
            const response = await this.makeRequest(`${this.config.apiBaseUrl}/companies/validate-ruc/${ruc}`);
            return response.success && response.data && response.data.is_valid;
        } catch (error) {
            console.error('Error validating RUC:', error);
            return false;
        }
    }

    // Método público para obtener empresa por RUC
    async getCompanyByRuc(ruc) {
        try {
            const response = await this.makeRequest(`${this.config.apiBaseUrl}/companies/ruc/${ruc}`);
            return response.success ? response.data : null;
        } catch (error) {
            console.error('Error getting company by RUC:', error);
            return null;
        }
    }

    // Método para limpiar todo
    clear() {
        const rucInput = document.getElementById(this.config.rucInputId);
        if (rucInput) {
            rucInput.value = '';
        }
        
        this.clearCompanyFields();
        this.hideSuggestions();
    }

    // Método para destruir el componente
    destroy() {
        clearTimeout(this.debounceTimer);
        
        if (this.currentRequest) {
            this.currentRequest.abort();
        }

        const container = document.getElementById(this.config.suggestionContainerId);
        if (container) {
            container.remove();
        }

        const messageEl = document.getElementById('company-autocomplete-message');
        if (messageEl) {
            messageEl.remove();
        }
    }
}

// Exportar para uso global
window.CompanyAutocomplete = CompanyAutocomplete;
