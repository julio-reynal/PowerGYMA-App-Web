/**
 * Location Selector Component
 * Maneja la selección dinámica de departamentos y provincias
 */
class LocationSelector {
    constructor(options = {}) {
        this.config = {
            departamentoSelectId: options.departamentoSelectId || 'departamento_id',
            provinciaSelectId: options.provinciaSelectId || 'provincia_id',
            apiBaseUrl: options.apiBaseUrl || '/api/v1',
            loadOnInit: options.loadOnInit !== false,
            defaultPlaceholders: {
                departamento: options.departamentoPlaceholder || 'Seleccione un departamento',
                provincia: options.provinciaPlaceholder || 'Seleccione una provincia'
            },
            allowSearch: options.allowSearch !== false,
            preselected: {
                departamento: options.preselectedDepartamento || null,
                provincia: options.preselectedProvincia || null
            }
        };

        this.cache = {
            departamentos: null,
            provincias: new Map()
        };

        this.isLoading = {
            departamentos: false,
            provincias: false
        };

        this.init();
    }

    init() {
        this.bindEvents();
        
        if (this.config.loadOnInit) {
            this.loadDepartamentos();
        }
    }

    bindEvents() {
        const departamentoSelect = document.getElementById(this.config.departamentoSelectId);
        const provinciaSelect = document.getElementById(this.config.provinciaSelectId);

        if (departamentoSelect) {
            departamentoSelect.addEventListener('change', (e) => {
                this.handleDepartamentoChange(e.target.value);
            });

            // Agregar búsqueda si está habilitada
            if (this.config.allowSearch) {
                this.makeSelectSearchable(departamentoSelect, 'departamento');
            }
        }

        if (provinciaSelect && this.config.allowSearch) {
            this.makeSelectSearchable(provinciaSelect, 'provincia');
        }
    }

    async loadDepartamentos() {
        try {
            this.setLoading('departamentos', true);
            
            const response = await this.makeRequest(`${this.config.apiBaseUrl}/locations/departamentos`);
            
            if (response.success && response.data) {
                this.cache.departamentos = response.data;
                this.populateDepartamentoSelect(response.data);
                
                // Preseleccionar si está configurado
                if (this.config.preselected.departamento) {
                    this.selectDepartamento(this.config.preselected.departamento);
                }
            } else {
                this.showError('Error al cargar los departamentos');
            }
        } catch (error) {
            console.error('Error loading departamentos:', error);
            this.showError('Error de conexión al cargar departamentos');
        } finally {
            this.setLoading('departamentos', false);
        }
    }

    async loadProvincias(departamentoId) {
        if (!departamentoId) {
            this.clearProvinciaSelect();
            return;
        }

        // Verificar cache primero
        if (this.cache.provincias.has(departamentoId)) {
            this.populateProvinciaSelect(this.cache.provincias.get(departamentoId));
            return;
        }

        try {
            this.setLoading('provincias', true);
            this.clearProvinciaSelect();
            
            const response = await this.makeRequest(
                `${this.config.apiBaseUrl}/locations/provincias/departamento/${departamentoId}`
            );
            
            if (response.success && response.data) {
                // Guardar en cache
                this.cache.provincias.set(departamentoId, response.data);
                this.populateProvinciaSelect(response.data);
                
                // Preseleccionar provincia si está configurado
                if (this.config.preselected.provincia) {
                    this.selectProvincia(this.config.preselected.provincia);
                }
            } else {
                this.showError('No se encontraron provincias para este departamento');
            }
        } catch (error) {
            console.error('Error loading provincias:', error);
            this.showError('Error al cargar las provincias');
        } finally {
            this.setLoading('provincias', false);
        }
    }

    populateDepartamentoSelect(departamentos) {
        const select = document.getElementById(this.config.departamentoSelectId);
        if (!select) return;

        // Limpiar opciones existentes excepto la primera (placeholder)
        const placeholder = select.querySelector('option[value=""]');
        select.innerHTML = '';
        
        // Agregar placeholder
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = this.config.defaultPlaceholders.departamento;
        defaultOption.disabled = true;
        defaultOption.selected = true;
        select.appendChild(defaultOption);

        // Agregar departamentos
        departamentos.forEach(departamento => {
            const option = document.createElement('option');
            option.value = departamento.id;
            option.textContent = departamento.nombre;
            option.dataset.codigo = departamento.codigo;
            option.dataset.ubigeo = departamento.ubigeo;
            select.appendChild(option);
        });

        this.updateSelectStatus(select, false);
    }

    populateProvinciaSelect(provincias) {
        const select = document.getElementById(this.config.provinciaSelectId);
        if (!select) return;

        // Limpiar opciones existentes
        select.innerHTML = '';
        
        // Agregar placeholder
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = this.config.defaultPlaceholders.provincia;
        defaultOption.disabled = true;
        defaultOption.selected = true;
        select.appendChild(defaultOption);

        // Agregar provincias
        provincias.forEach(provincia => {
            const option = document.createElement('option');
            option.value = provincia.id;
            option.textContent = provincia.nombre;
            option.dataset.codigo = provincia.codigo;
            option.dataset.ubigeo = provincia.ubigeo;
            select.appendChild(option);
        });

        this.updateSelectStatus(select, false);
    }

    clearProvinciaSelect() {
        const select = document.getElementById(this.config.provinciaSelectId);
        if (!select) return;

        select.innerHTML = '';
        
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = this.config.defaultPlaceholders.provincia;
        defaultOption.disabled = true;
        defaultOption.selected = true;
        select.appendChild(defaultOption);

        this.updateSelectStatus(select, true);
    }

    handleDepartamentoChange(departamentoId) {
        if (departamentoId) {
            this.loadProvincias(departamentoId);
            
            // Disparar evento personalizado
            this.dispatchEvent('departamentoChanged', {
                departamentoId: departamentoId,
                departamento: this.getDepartamentoById(departamentoId)
            });
        } else {
            this.clearProvinciaSelect();
        }
    }

    makeSelectSearchable(select, type) {
        // Crear wrapper para el select con búsqueda
        const wrapper = document.createElement('div');
        wrapper.className = 'searchable-select-wrapper';
        wrapper.style.cssText = 'position: relative; width: 100%;';

        // Crear input de búsqueda
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.className = 'searchable-select-input';
        searchInput.placeholder = `Buscar ${type}...`;
        searchInput.style.cssText = `
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        `;

        // Crear dropdown personalizado
        const dropdown = document.createElement('div');
        dropdown.className = 'searchable-select-dropdown';
        dropdown.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 4px 4px;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        `;

        // Insertar antes del select original
        select.parentNode.insertBefore(wrapper, select);
        wrapper.appendChild(searchInput);
        wrapper.appendChild(dropdown);
        
        // Ocultar select original
        select.style.display = 'none';

        // Almacenar referencias
        searchInput.originalSelect = select;
        searchInput.dropdown = dropdown;

        // Eventos de búsqueda
        let searchTimeout;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.filterOptions(searchInput, e.target.value, type);
            }, 200);
        });

        searchInput.addEventListener('focus', () => {
            this.showDropdown(searchInput);
        });

        searchInput.addEventListener('blur', () => {
            setTimeout(() => this.hideDropdown(searchInput), 150);
        });

        // Click fuera para cerrar
        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) {
                this.hideDropdown(searchInput);
            }
        });
    }

    filterOptions(searchInput, query, type) {
        const dropdown = searchInput.dropdown;
        const select = searchInput.originalSelect;
        
        dropdown.innerHTML = '';

        if (!query || query.length < 1) {
            this.populateDropdown(searchInput, Array.from(select.options).slice(1)); // Excluir placeholder
            return;
        }

        const filteredOptions = Array.from(select.options)
            .filter(option => 
                option.value && 
                option.textContent.toLowerCase().includes(query.toLowerCase())
            );

        if (filteredOptions.length === 0) {
            const noResults = document.createElement('div');
            noResults.className = 'dropdown-item no-results';
            noResults.textContent = `No se encontraron ${type}s`;
            noResults.style.cssText = 'padding: 10px; color: #999; font-style: italic;';
            dropdown.appendChild(noResults);
        } else {
            this.populateDropdown(searchInput, filteredOptions);
        }

        this.showDropdown(searchInput);
    }

    populateDropdown(searchInput, options) {
        const dropdown = searchInput.dropdown;
        
        options.forEach(option => {
            const item = document.createElement('div');
            item.className = 'dropdown-item';
            item.textContent = option.textContent;
            item.dataset.value = option.value;
            item.style.cssText = `
                padding: 10px;
                cursor: pointer;
                border-bottom: 1px solid #eee;
                transition: background-color 0.2s;
            `;

            item.addEventListener('mouseenter', () => {
                item.style.backgroundColor = '#f5f5f5';
            });

            item.addEventListener('mouseleave', () => {
                item.style.backgroundColor = 'white';
            });

            item.addEventListener('click', () => {
                this.selectOption(searchInput, option.value, option.textContent);
            });

            dropdown.appendChild(item);
        });
    }

    selectOption(searchInput, value, text) {
        const select = searchInput.originalSelect;
        
        // Actualizar select original
        select.value = value;
        
        // Actualizar input de búsqueda
        searchInput.value = text;
        
        // Disparar evento change en el select original
        select.dispatchEvent(new Event('change'));
        
        this.hideDropdown(searchInput);
    }

    showDropdown(searchInput) {
        const dropdown = searchInput.dropdown;
        
        if (dropdown.children.length === 0) {
            this.filterOptions(searchInput, '', 'departamento'); // Mostrar todos inicialmente
        }
        
        dropdown.style.display = 'block';
    }

    hideDropdown(searchInput) {
        const dropdown = searchInput.dropdown;
        dropdown.style.display = 'none';
    }

    async makeRequest(url) {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    }

    setLoading(type, loading) {
        this.isLoading[type] = loading;
        
        const selectId = type === 'departamentos' ? 
            this.config.departamentoSelectId : 
            this.config.provinciaSelectId;
            
        const select = document.getElementById(selectId);
        
        this.updateSelectStatus(select, loading);
    }

    updateSelectStatus(select, disabled) {
        if (!select) return;
        
        select.disabled = disabled;
        
        if (disabled) {
            select.style.opacity = '0.6';
            select.style.cursor = 'not-allowed';
        } else {
            select.style.opacity = '1';
            select.style.cursor = 'pointer';
        }
    }

    getDepartamentoById(id) {
        if (!this.cache.departamentos) return null;
        return this.cache.departamentos.find(dep => dep.id == id);
    }

    getProvinciaById(departamentoId, provinciaId) {
        const provincias = this.cache.provincias.get(departamentoId);
        if (!provincias) return null;
        return provincias.find(prov => prov.id == provinciaId);
    }

    // Métodos públicos
    selectDepartamento(departamentoId) {
        const select = document.getElementById(this.config.departamentoSelectId);
        if (select) {
            select.value = departamentoId;
            select.dispatchEvent(new Event('change'));
        }
    }

    selectProvincia(provinciaId) {
        const select = document.getElementById(this.config.provinciaSelectId);
        if (select) {
            select.value = provinciaId;
            select.dispatchEvent(new Event('change'));
        }
    }

    getSelectedDepartamento() {
        const select = document.getElementById(this.config.departamentoSelectId);
        return select ? select.value : null;
    }

    getSelectedProvincia() {
        const select = document.getElementById(this.config.provinciaSelectId);
        return select ? select.value : null;
    }

    getSelectedLocationData() {
        const departamentoId = this.getSelectedDepartamento();
        const provinciaId = this.getSelectedProvincia();
        
        return {
            departamento: departamentoId ? this.getDepartamentoById(departamentoId) : null,
            provincia: provinciaId && departamentoId ? this.getProvinciaById(departamentoId, provinciaId) : null
        };
    }

    // Reiniciar selecciones
    reset() {
        const departamentoSelect = document.getElementById(this.config.departamentoSelectId);
        const provinciaSelect = document.getElementById(this.config.provinciaSelectId);
        
        if (departamentoSelect) {
            departamentoSelect.value = '';
        }
        
        if (provinciaSelect) {
            provinciaSelect.value = '';
        }
        
        this.clearProvinciaSelect();
    }

    // Sistema de eventos
    dispatchEvent(eventName, data) {
        const event = new CustomEvent(`locationSelector:${eventName}`, {
            detail: data
        });
        document.dispatchEvent(event);
    }

    // Escuchar eventos
    on(eventName, callback) {
        document.addEventListener(`locationSelector:${eventName}`, callback);
    }

    off(eventName, callback) {
        document.removeEventListener(`locationSelector:${eventName}`, callback);
    }

    showError(message) {
        this.showMessage(message, 'error');
    }

    showMessage(message, type = 'info') {
        // Reutilizar el sistema de mensajes del CompanyAutocomplete si existe
        if (window.CompanyAutocomplete) {
            const tempInstance = new window.CompanyAutocomplete();
            tempInstance.showMessage(message, type);
            return;
        }

        // Sistema básico de mensajes
        let messageEl = document.getElementById('location-selector-message');
        
        if (!messageEl) {
            messageEl = document.createElement('div');
            messageEl.id = 'location-selector-message';
            messageEl.style.cssText = `
                position: fixed;
                top: 60px;
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

        const styles = {
            success: 'background: #d4edda; color: #155724; border: 1px solid #c3e6cb;',
            error: 'background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;',
            info: 'background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb;'
        };

        messageEl.style.cssText += styles[type] || styles.info;
        messageEl.textContent = message;

        setTimeout(() => {
            if (messageEl && messageEl.parentNode) {
                messageEl.remove();
            }
        }, 3000);
    }

    // Destruir componente
    destroy() {
        this.cache.departamentos = null;
        this.cache.provincias.clear();
        
        const messageEl = document.getElementById('location-selector-message');
        if (messageEl) {
            messageEl.remove();
        }
    }
}

// Exportar para uso global
window.LocationSelector = LocationSelector;
