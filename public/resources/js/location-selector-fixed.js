/**
 * Location Selector Component - VERSIÓN CORREGIDA
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
        console.log('🚀 Inicializando LocationSelector...');
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
        }

        if (provinciaSelect) {
            provinciaSelect.addEventListener('change', (e) => {
                this.handleProvinciaChange(e.target.value);
            });
        }
    }

    async loadDepartamentos() {
        try {
            console.log('📦 Cargando departamentos...');
            this.setLoading('departamentos', true);
            
            const response = await this.makeRequest(`${this.config.apiBaseUrl}/locations/departamentos`);
            
            if (response.success && response.data) {
                this.cache.departamentos = response.data;
                this.populateDepartamentoSelect(response.data);
                console.log(`✅ ${response.data.length} departamentos cargados`);
                
                // Preseleccionar si está configurado
                if (this.config.preselected.departamento) {
                    this.selectDepartamento(this.config.preselected.departamento);
                }
                
                // Disparar evento personalizado
                this.dispatchEvent('departamentoLoaded', { count: response.data.length });
            } else {
                console.error('❌ Error en respuesta de departamentos:', response);
                this.showError('Error al cargar los departamentos');
            }
        } catch (error) {
            console.error('❌ Error loading departamentos:', error);
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
            console.log('📋 Usando provincias del cache');
            this.populateProvinciaSelect(this.cache.provincias.get(departamentoId));
            return;
        }

        try {
            console.log(`🏘️ Cargando provincias para departamento ${departamentoId}...`);
            this.setLoading('provincias', true);
            this.clearProvinciaSelect();
            
            const response = await this.makeRequest(
                `${this.config.apiBaseUrl}/locations/provincias/departamento/${departamentoId}`
            );
            
            if (response.success && response.data) {
                // Guardar en cache
                this.cache.provincias.set(departamentoId, response.data);
                this.populateProvinciaSelect(response.data);
                console.log(`✅ ${response.data.length} provincias cargadas`);
                
                // Preseleccionar provincia si está configurada
                if (this.config.preselected.provincia) {
                    this.selectProvincia(this.config.preselected.provincia);
                }
                
                // Disparar evento personalizado
                this.dispatchEvent('provinciasLoaded', { 
                    departamentoId: departamentoId,
                    count: response.data.length 
                });
            } else {
                console.error('❌ Error en respuesta de provincias:', response);
                this.showError('No se encontraron provincias para este departamento');
            }
        } catch (error) {
            console.error('❌ Error loading provincias:', error);
            this.showError('Error de conexión al cargar provincias');
        } finally {
            this.setLoading('provincias', false);
        }
    }

    populateDepartamentoSelect(departamentos) {
        const select = document.getElementById(this.config.departamentoSelectId);
        if (!select) {
            console.error('❌ Select de departamento no encontrado:', this.config.departamentoSelectId);
            return;
        }

        // Limpiar opciones existentes
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
            select.appendChild(option);
        });

        this.updateSelectStatus(select, false);
    }

    populateProvinciaSelect(provincias) {
        const select = document.getElementById(this.config.provinciaSelectId);
        if (!select) {
            console.error('❌ Select de provincia no encontrado:', this.config.provinciaSelectId);
            return;
        }

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
        defaultOption.textContent = 'Primero seleccione un departamento';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        select.appendChild(defaultOption);
    }

    handleDepartamentoChange(departamentoId) {
        console.log('🔄 Departamento cambiado:', departamentoId);
        
        if (departamentoId) {
            const departamento = this.getDepartamentoById(departamentoId);
            if (departamento) {
                this.dispatchEvent('departamentoChanged', { 
                    departamento: departamento 
                });
            }
            this.loadProvincias(departamentoId);
        } else {
            this.clearProvinciaSelect();
        }
    }

    handleProvinciaChange(provinciaId) {
        console.log('🔄 Provincia cambiada:', provinciaId);
        
        if (provinciaId) {
            const provincia = this.getProvinciaById(provinciaId);
            if (provincia) {
                this.dispatchEvent('provinciaChanged', { 
                    provincia: provincia 
                });
            }
        }
    }

    getDepartamentoById(id) {
        if (!this.cache.departamentos) return null;
        return this.cache.departamentos.find(dept => dept.id == id);
    }

    getProvinciaById(id) {
        for (let provincias of this.cache.provincias.values()) {
            const provincia = provincias.find(prov => prov.id == id);
            if (provincia) return provincia;
        }
        return null;
    }

    selectDepartamento(departamentoId) {
        const select = document.getElementById(this.config.departamentoSelectId);
        if (select && departamentoId) {
            select.value = departamentoId;
            this.handleDepartamentoChange(departamentoId);
        }
    }

    selectProvincia(provinciaId) {
        const select = document.getElementById(this.config.provinciaSelectId);
        if (select && provinciaId) {
            select.value = provinciaId;
            this.handleProvinciaChange(provinciaId);
        }
    }

    getSelectedLocationData() {
        const deptSelect = document.getElementById(this.config.departamentoSelectId);
        const provSelect = document.getElementById(this.config.provinciaSelectId);
        
        return {
            departamento: {
                id: deptSelect ? deptSelect.value : null,
                data: this.getDepartamentoById(deptSelect?.value)
            },
            provincia: {
                id: provSelect ? provSelect.value : null,
                data: this.getProvinciaById(provSelect?.value)
            }
        };
    }

    reset() {
        const deptSelect = document.getElementById(this.config.departamentoSelectId);
        const provSelect = document.getElementById(this.config.provinciaSelectId);
        
        if (deptSelect) deptSelect.value = '';
        if (provSelect) this.clearProvinciaSelect();
    }

    async makeRequest(url) {
        console.log('🌐 Haciendo request a:', url);
        
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

        const data = await response.json();
        console.log('📡 Respuesta recibida:', data);
        return data;
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
            select.classList.add('loading');
        } else {
            select.classList.remove('loading');
        }
    }

    showError(message) {
        console.error('❌ LocationSelector Error:', message);
        
        // Disparar evento de error
        this.dispatchEvent('error', { message: message });
        
        // Mostrar en consola
        if (window.console) {
            console.error('LocationSelector:', message);
        }
    }

    dispatchEvent(eventName, detail = {}) {
        const event = new CustomEvent(eventName, { 
            detail: detail,
            bubbles: true 
        });
        document.dispatchEvent(event);
    }

    // Método para limpiar el cache
    clearCache() {
        this.cache.departamentos = null;
        this.cache.provincias.clear();
        console.log('🧹 Cache limpiado');
    }

    // Método para destruir el componente
    destroy() {
        // Limpiar eventos si es necesario
        this.clearCache();
        console.log('🗑️ LocationSelector destruido');
    }
}

// Hacer la clase disponible globalmente
window.LocationSelector = LocationSelector;

console.log('📦 LocationSelector cargado correctamente');
