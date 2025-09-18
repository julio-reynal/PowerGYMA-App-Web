/**
 * Advanced Location Autocomplete Component
 * FASE 4: FUNCIONALIDAD DE AUTOCOMPLETADO AVANZADO
 * Versión mejorada con búsqueda en tiempo real, debounce optimizado y UX avanzada
 */
class AdvancedLocationAutocomplete {
    constructor(options = {}) {
        this.config = {
            // Elementos del DOM
            departamentoInputId: options.departamentoInputId || 'departamento_autocomplete',
            provinciaInputId: options.provinciaInputId || 'provincia_autocomplete',
            departamentoHiddenId: options.departamentoHiddenId || 'departamento_id',
            provinciaHiddenId: options.provinciaHiddenId || 'provincia_id',
            
            // API
            apiBaseUrl: options.apiBaseUrl || '/api/v1',
            
            // Configuración de búsqueda
            minSearchLength: options.minSearchLength || 2,
            searchDelay: options.searchDelay || 300,
            maxResults: options.maxResults || 10,
            
            // Placeholders
            placeholders: {
                departamento: options.departamentoPlaceholder || 'Buscar departamento...',
                provincia: options.provinciaPlaceholder || 'Buscar provincia...',
                provinciaDisabled: options.provinciaDisabledPlaceholder || 'Primero seleccione un departamento'
            },
            
            // Mensajes
            messages: {
                noResults: options.noResultsMessage || 'No se encontraron resultados',
                searching: options.searchingMessage || 'Buscando...',
                selectDepartment: options.selectDepartmentMessage || 'Primero debe seleccionar un departamento',
                networkError: options.networkErrorMessage || 'Error de conexión. Intente nuevamente.',
                loadingDepartments: options.loadingDepartmentsMessage || 'Cargando departamentos...'
            },
            
            // Opciones avanzadas
            enableKeyboardNavigation: options.enableKeyboardNavigation !== false,
            enableHighlighting: options.enableHighlighting !== false,
            enableFuzzySearch: options.enableFuzzySearch !== false,
            preloadDepartments: options.preloadDepartments !== false,
            cacheResults: options.cacheResults !== false,
            
            // Callbacks
            onDepartmentSelect: options.onDepartmentSelect || null,
            onProvinceSelect: options.onProvinceSelect || null,
            onClear: options.onClear || null,
            onError: options.onError || null
        };

        // Estado del componente
        this.state = {
            selectedDepartment: null,
            selectedProvince: null,
            isLoadingDepartments: false,
            isLoadingProvinces: false,
            departmentResults: [],
            provinceResults: [],
            activeSuggestionIndex: -1,
            lastQuery: {
                department: '',
                province: ''
            }
        };

        // Cache
        this.cache = {
            departments: null,
            provinces: new Map(),
            searchResults: new Map()
        };

        // Referencias DOM
        this.elements = {};

        // Timeouts para debounce
        this.timeouts = {
            departmentSearch: null,
            provinceSearch: null
        };

        this.init();
    }

    async init() {
        try {
            this.initializeElements();
            this.createComponents();
            this.bindEvents();
            
            if (this.config.preloadDepartments) {
                await this.preloadDepartments();
            }
            
            this.log('🚀 AdvancedLocationAutocomplete inicializado correctamente');
        } catch (error) {
            this.handleError('Error inicializando el componente de autocompletado', error);
        }
    }

    initializeElements() {
        // Buscar elementos existentes o crearlos
        this.elements = {
            departmentInput: document.getElementById(this.config.departamentoInputId),
            provinceInput: document.getElementById(this.config.provinciaInputId),
            departmentHidden: document.getElementById(this.config.departamentoHiddenId),
            provinceHidden: document.getElementById(this.config.provinciaHiddenId)
        };

        // Validar elementos requeridos
        if (!this.elements.departmentInput || !this.elements.provinceInput) {
            throw new Error('Elementos de input requeridos no encontrados');
        }
    }

    createComponents() {
        // Crear componente de autocompletado para departamento
        this.createAutocompleteComponent(
            this.elements.departmentInput,
            'department',
            this.config.placeholders.departamento
        );

        // Crear componente de autocompletado para provincia
        this.createAutocompleteComponent(
            this.elements.provinceInput,
            'province',
            this.config.placeholders.provincia
        );

        // Deshabilitar provincia inicialmente
        this.setProvinceInputState(false);
    }

    createAutocompleteComponent(input, type, placeholder) {
        // Crear contenedor wrapper
        const wrapper = document.createElement('div');
        wrapper.className = `autocomplete-wrapper autocomplete-${type}`;
        wrapper.style.cssText = 'position: relative; width: 100%;';

        // Mover input al wrapper
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);

        // Configurar input
        input.className += ' autocomplete-input';
        input.placeholder = placeholder;
        input.autocomplete = 'off';
        input.style.cssText = `
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background: white;
        `;

        // Crear dropdown de sugerencias
        const dropdown = document.createElement('div');
        dropdown.className = `autocomplete-dropdown autocomplete-${type}-dropdown`;
        dropdown.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #e1e5e9;
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 300px;
            overflow-y: auto;
            display: none;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;
        wrapper.appendChild(dropdown);

        // Crear indicador de carga
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = `loading-indicator loading-${type}`;
        loadingIndicator.innerHTML = `
            <div style="padding: 16px; text-align: center; color: #6c757d;">
                <div class="spinner" style="display: inline-block; width: 16px; height: 16px; border: 2px solid #f3f3f3; border-top: 2px solid #007bff; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                <span style="margin-left: 8px;">${this.config.messages.searching}</span>
            </div>
        `;
        loadingIndicator.style.display = 'none';
        wrapper.appendChild(loadingIndicator);

        // Crear ícono de estado
        const statusIcon = document.createElement('div');
        statusIcon.className = `status-icon status-${type}`;
        statusIcon.style.cssText = `
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #6c757d;
            pointer-events: none;
        `;
        wrapper.appendChild(statusIcon);

        // Almacenar referencias
        if (type === 'department') {
            this.elements.departmentWrapper = wrapper;
            this.elements.departmentDropdown = dropdown;
            this.elements.departmentLoading = loadingIndicator;
            this.elements.departmentStatus = statusIcon;
        } else {
            this.elements.provinceWrapper = wrapper;
            this.elements.provinceDropdown = dropdown;
            this.elements.provinceLoading = loadingIndicator;
            this.elements.provinceStatus = statusIcon;
        }
    }

    bindEvents() {
        // Eventos para departamento
        this.elements.departmentInput.addEventListener('input', (e) => {
            this.handleDepartmentSearch(e.target.value);
        });

        this.elements.departmentInput.addEventListener('focus', () => {
            this.showSuggestions('department');
        });

        this.elements.departmentInput.addEventListener('blur', () => {
            setTimeout(() => this.hideSuggestions('department'), 150);
        });

        // Eventos para provincia
        this.elements.provinceInput.addEventListener('input', (e) => {
            this.handleProvinceSearch(e.target.value);
        });

        this.elements.provinceInput.addEventListener('focus', () => {
            if (this.state.selectedDepartment) {
                this.showSuggestions('province');
            } else {
                this.showMessage(this.config.messages.selectDepartment, 'warning');
            }
        });

        this.elements.provinceInput.addEventListener('blur', () => {
            setTimeout(() => this.hideSuggestions('province'), 150);
        });

        // Eventos de teclado para navegación
        if (this.config.enableKeyboardNavigation) {
            this.bindKeyboardEvents();
        }

        // Click fuera para cerrar dropdowns
        document.addEventListener('click', (e) => {
            if (!this.elements.departmentWrapper.contains(e.target)) {
                this.hideSuggestions('department');
            }
            if (!this.elements.provinceWrapper.contains(e.target)) {
                this.hideSuggestions('province');
            }
        });
    }

    bindKeyboardEvents() {
        [this.elements.departmentInput, this.elements.provinceInput].forEach(input => {
            input.addEventListener('keydown', (e) => {
                const type = input === this.elements.departmentInput ? 'department' : 'province';
                this.handleKeydown(e, type);
            });
        });
    }

    handleKeydown(e, type) {
        const dropdown = type === 'department' ? 
            this.elements.departmentDropdown : 
            this.elements.provinceDropdown;
        
        const suggestions = dropdown.querySelectorAll('.suggestion-item:not(.no-results)');
        
        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault();
                this.state.activeSuggestionIndex = Math.min(
                    this.state.activeSuggestionIndex + 1,
                    suggestions.length - 1
                );
                this.updateActiveSuggestion(suggestions);
                break;
                
            case 'ArrowUp':
                e.preventDefault();
                this.state.activeSuggestionIndex = Math.max(
                    this.state.activeSuggestionIndex - 1,
                    -1
                );
                this.updateActiveSuggestion(suggestions);
                break;
                
            case 'Enter':
                e.preventDefault();
                if (this.state.activeSuggestionIndex >= 0 && suggestions[this.state.activeSuggestionIndex]) {
                    suggestions[this.state.activeSuggestionIndex].click();
                }
                break;
                
            case 'Escape':
                this.hideSuggestions(type);
                break;
        }
    }

    updateActiveSuggestion(suggestions) {
        suggestions.forEach((item, index) => {
            if (index === this.state.activeSuggestionIndex) {
                item.classList.add('active');
                item.scrollIntoView({ block: 'nearest' });
            } else {
                item.classList.remove('active');
            }
        });
    }

    async preloadDepartments() {
        try {
            this.state.isLoadingDepartments = true;
            this.showLoadingState('department');
            
            const departments = await this.fetchDepartments();
            this.cache.departments = departments;
            
            this.log(`📦 ${departments.length} departamentos precargados`);
        } catch (error) {
            this.handleError('Error precargando departamentos', error);
        } finally {
            this.state.isLoadingDepartments = false;
            this.hideLoadingState('department');
        }
    }

    async handleDepartmentSearch(query) {
        this.state.lastQuery.department = query;
        
        // Limpiar timeout anterior
        if (this.timeouts.departmentSearch) {
            clearTimeout(this.timeouts.departmentSearch);
        }

        // Si la query está vacía, limpiar todo
        if (!query.trim()) {
            this.clearDepartmentSelection();
            this.hideSuggestions('department');
            return;
        }

        // Si la query es muy corta, no buscar
        if (query.length < this.config.minSearchLength) {
            this.hideSuggestions('department');
            return;
        }

        // Debounce la búsqueda
        this.timeouts.departmentSearch = setTimeout(async () => {
            try {
                await this.searchDepartments(query);
            } catch (error) {
                this.handleError('Error buscando departamentos', error);
            }
        }, this.config.searchDelay);
    }

    async handleProvinceSearch(query) {
        this.state.lastQuery.province = query;
        
        if (!this.state.selectedDepartment) {
            this.showMessage(this.config.messages.selectDepartment, 'warning');
            return;
        }

        // Limpiar timeout anterior
        if (this.timeouts.provinceSearch) {
            clearTimeout(this.timeouts.provinceSearch);
        }

        // Si la query está vacía, mostrar todas las provincias del departamento
        if (!query.trim()) {
            this.clearProvinceSelection();
            await this.loadAllProvinces();
            return;
        }

        // Si la query es muy corta, no buscar
        if (query.length < this.config.minSearchLength) {
            this.hideSuggestions('province');
            return;
        }

        // Debounce la búsqueda
        this.timeouts.provinceSearch = setTimeout(async () => {
            try {
                await this.searchProvinces(query);
            } catch (error) {
                this.handleError('Error buscando provincias', error);
            }
        }, this.config.searchDelay);
    }

    async searchDepartments(query) {
        this.showLoadingState('department');
        
        try {
            // Verificar cache primero
            const cacheKey = `dept_${query.toLowerCase()}`;
            if (this.config.cacheResults && this.cache.searchResults.has(cacheKey)) {
                const cachedResults = this.cache.searchResults.get(cacheKey);
                this.displayDepartmentSuggestions(cachedResults, query);
                return;
            }

            let results;
            
            // Si tenemos departamentos precargados, buscar localmente
            if (this.cache.departments) {
                results = this.filterDepartmentsLocally(query);
            } else {
                // Buscar via API
                results = await this.fetchDepartmentSearch(query);
            }

            // Guardar en cache
            if (this.config.cacheResults) {
                this.cache.searchResults.set(cacheKey, results);
            }

            this.displayDepartmentSuggestions(results, query);
            
        } finally {
            this.hideLoadingState('department');
        }
    }

    async searchProvinces(query) {
        if (!this.state.selectedDepartment) return;
        
        this.showLoadingState('province');
        
        try {
            // Verificar cache primero
            const cacheKey = `prov_${this.state.selectedDepartment.id}_${query.toLowerCase()}`;
            if (this.config.cacheResults && this.cache.searchResults.has(cacheKey)) {
                const cachedResults = this.cache.searchResults.get(cacheKey);
                this.displayProvinceSuggestions(cachedResults, query);
                return;
            }

            let results;
            
            // Si tenemos provincias del departamento en cache, buscar localmente
            if (this.cache.provinces.has(this.state.selectedDepartment.id)) {
                const provinces = this.cache.provinces.get(this.state.selectedDepartment.id);
                results = this.filterProvincesLocally(provinces, query);
            } else {
                // Buscar via API
                results = await this.fetchProvinceSearch(query, this.state.selectedDepartment.id);
            }

            // Guardar en cache
            if (this.config.cacheResults) {
                this.cache.searchResults.set(cacheKey, results);
            }

            this.displayProvinceSuggestions(results, query);
            
        } finally {
            this.hideLoadingState('province');
        }
    }

    filterDepartmentsLocally(query) {
        const departments = this.cache.departments || [];
        const normalizedQuery = this.normalizeString(query);
        
        return departments.filter(dept => {
            const normalizedName = this.normalizeString(dept.nombre);
            
            if (this.config.enableFuzzySearch) {
                return this.fuzzyMatch(normalizedName, normalizedQuery);
            } else {
                return normalizedName.includes(normalizedQuery);
            }
        }).slice(0, this.config.maxResults);
    }

    filterProvincesLocally(provinces, query) {
        const normalizedQuery = this.normalizeString(query);
        
        return provinces.filter(prov => {
            const normalizedName = this.normalizeString(prov.nombre);
            
            if (this.config.enableFuzzySearch) {
                return this.fuzzyMatch(normalizedName, normalizedQuery);
            } else {
                return normalizedName.includes(normalizedQuery);
            }
        }).slice(0, this.config.maxResults);
    }

    normalizeString(str) {
        return str.toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '') // Remover acentos
            .trim();
    }

    fuzzyMatch(text, query) {
        // Algoritmo simple de fuzzy matching
        let textIndex = 0;
        let queryIndex = 0;
        
        while (textIndex < text.length && queryIndex < query.length) {
            if (text[textIndex] === query[queryIndex]) {
                queryIndex++;
            }
            textIndex++;
        }
        
        return queryIndex === query.length;
    }

    async fetchDepartments() {
        const response = await this.makeRequest(`${this.config.apiBaseUrl}/locations/departamentos`);
        if (response.success && response.data) {
            return response.data;
        }
        throw new Error('No se pudieron cargar los departamentos');
    }

    async fetchDepartmentSearch(query) {
        const response = await this.makeRequest(
            `${this.config.apiBaseUrl}/locations/departamentos/search?q=${encodeURIComponent(query)}&limit=${this.config.maxResults}`
        );
        if (response.success && response.data) {
            return response.data;
        }
        return [];
    }

    async fetchProvinceSearch(query, departmentId) {
        const response = await this.makeRequest(
            `${this.config.apiBaseUrl}/locations/provincias/search?q=${encodeURIComponent(query)}&departamento_id=${departmentId}&limit=${this.config.maxResults}`
        );
        if (response.success && response.data) {
            return response.data;
        }
        return [];
    }

    async loadAllProvinces() {
        if (!this.state.selectedDepartment) return;
        
        const departmentId = this.state.selectedDepartment.id;
        
        // Verificar cache
        if (this.cache.provinces.has(departmentId)) {
            const provinces = this.cache.provinces.get(departmentId);
            this.displayProvinceSuggestions(provinces.slice(0, this.config.maxResults));
            return;
        }

        this.showLoadingState('province');
        
        try {
            const response = await this.makeRequest(
                `${this.config.apiBaseUrl}/locations/provincias/departamento/${departmentId}`
            );
            
            if (response.success && response.data) {
                this.cache.provinces.set(departmentId, response.data);
                this.displayProvinceSuggestions(response.data.slice(0, this.config.maxResults));
            }
        } catch (error) {
            this.handleError('Error cargando provincias', error);
        } finally {
            this.hideLoadingState('province');
        }
    }

    displayDepartmentSuggestions(departments, query = '') {
        this.state.departmentResults = departments;
        this.renderSuggestions('department', departments, query);
        this.showSuggestions('department');
    }

    displayProvinceSuggestions(provinces, query = '') {
        this.state.provinceResults = provinces;
        this.renderSuggestions('province', provinces, query);
        this.showSuggestions('province');
    }

    renderSuggestions(type, items, query = '') {
        const dropdown = type === 'department' ? 
            this.elements.departmentDropdown : 
            this.elements.provinceDropdown;
        
        dropdown.innerHTML = '';
        this.state.activeSuggestionIndex = -1;

        if (items.length === 0) {
            const noResults = document.createElement('div');
            noResults.className = 'suggestion-item no-results';
            noResults.style.cssText = `
                padding: 16px;
                text-align: center;
                color: #6c757d;
                font-style: italic;
                border-bottom: none;
            `;
            noResults.textContent = this.config.messages.noResults;
            dropdown.appendChild(noResults);
            return;
        }

        items.forEach((item, index) => {
            const suggestionEl = document.createElement('div');
            suggestionEl.className = 'suggestion-item';
            suggestionEl.style.cssText = `
                padding: 12px 16px;
                cursor: pointer;
                border-bottom: 1px solid #f1f3f4;
                transition: all 0.2s ease;
                display: flex;
                justify-content: space-between;
                align-items: center;
            `;

            // Contenido principal
            const mainContent = document.createElement('div');
            mainContent.style.cssText = 'flex: 1;';
            
            // Nombre destacado
            const nameEl = document.createElement('div');
            nameEl.style.cssText = 'font-weight: 500; color: #2c3e50;';
            nameEl.innerHTML = this.config.enableHighlighting && query ? 
                this.highlightText(item.nombre, query) : 
                item.nombre;
            mainContent.appendChild(nameEl);

            // Información adicional para provincias
            if (type === 'province' && item.departamento) {
                const deptEl = document.createElement('div');
                deptEl.style.cssText = 'font-size: 12px; color: #6c757d; margin-top: 2px;';
                deptEl.textContent = item.departamento.nombre;
                mainContent.appendChild(deptEl);
            }

            suggestionEl.appendChild(mainContent);

            // Código como badge
            if (item.codigo) {
                const codeEl = document.createElement('span');
                codeEl.style.cssText = `
                    background: #e9ecef;
                    color: #495057;
                    padding: 2px 6px;
                    border-radius: 4px;
                    font-size: 11px;
                    font-family: monospace;
                `;
                codeEl.textContent = item.codigo;
                suggestionEl.appendChild(codeEl);
            }

            // Eventos
            suggestionEl.addEventListener('mouseenter', () => {
                this.state.activeSuggestionIndex = index;
                this.updateActiveSuggestion([suggestionEl]);
                suggestionEl.style.backgroundColor = '#f8f9fa';
            });

            suggestionEl.addEventListener('mouseleave', () => {
                suggestionEl.style.backgroundColor = 'white';
            });

            suggestionEl.addEventListener('click', () => {
                if (type === 'department') {
                    this.selectDepartment(item);
                } else {
                    this.selectProvince(item);
                }
            });

            dropdown.appendChild(suggestionEl);
        });
    }

    highlightText(text, query) {
        if (!query || !this.config.enableHighlighting) return text;
        
        const normalizedText = this.normalizeString(text);
        const normalizedQuery = this.normalizeString(query);
        const index = normalizedText.indexOf(normalizedQuery);
        
        if (index === -1) return text;
        
        const start = text.substring(0, index);
        const match = text.substring(index, index + query.length);
        const end = text.substring(index + query.length);
        
        return `${start}<mark style="background: #fff3cd; padding: 0 2px; border-radius: 2px;">${match}</mark>${end}`;
    }

    selectDepartment(department) {
        this.state.selectedDepartment = department;
        this.elements.departmentInput.value = department.nombre;
        
        if (this.elements.departmentHidden) {
            this.elements.departmentHidden.value = department.id;
        }

        this.updateStatusIcon('department', '✓', '#28a745');
        this.hideSuggestions('department');
        
        // Limpiar provincia y habilitar su input
        this.clearProvinceSelection();
        this.setProvinceInputState(true);
        
        // Callback
        if (this.config.onDepartmentSelect) {
            this.config.onDepartmentSelect(department);
        }

        this.log(`🏛️ Departamento seleccionado: ${department.nombre}`);
    }

    selectProvince(province) {
        this.state.selectedProvince = province;
        this.elements.provinceInput.value = province.nombre;
        
        if (this.elements.provinceHidden) {
            this.elements.provinceHidden.value = province.id;
        }

        this.updateStatusIcon('province', '✓', '#28a745');
        this.hideSuggestions('province');
        
        // Callback
        if (this.config.onProvinceSelect) {
            this.config.onProvinceSelect(province);
        }

        this.log(`🏘️ Provincia seleccionada: ${province.nombre}`);
    }

    clearDepartmentSelection() {
        this.state.selectedDepartment = null;
        
        if (this.elements.departmentHidden) {
            this.elements.departmentHidden.value = '';
        }

        this.updateStatusIcon('department', '', '');
        this.clearProvinceSelection();
        this.setProvinceInputState(false);
    }

    clearProvinceSelection() {
        this.state.selectedProvince = null;
        this.elements.provinceInput.value = '';
        
        if (this.elements.provinceHidden) {
            this.elements.provinceHidden.value = '';
        }

        this.updateStatusIcon('province', '', '');
    }

    setProvinceInputState(enabled) {
        this.elements.provinceInput.disabled = !enabled;
        this.elements.provinceInput.placeholder = enabled ? 
            this.config.placeholders.provincia : 
            this.config.placeholders.provinciaDisabled;
        
        if (enabled) {
            this.elements.provinceInput.style.backgroundColor = 'white';
            this.elements.provinceInput.style.cursor = 'text';
        } else {
            this.elements.provinceInput.style.backgroundColor = '#f8f9fa';
            this.elements.provinceInput.style.cursor = 'not-allowed';
        }
    }

    updateStatusIcon(type, icon, color) {
        const statusEl = type === 'department' ? 
            this.elements.departmentStatus : 
            this.elements.provinceStatus;
        
        statusEl.textContent = icon;
        statusEl.style.color = color;
    }

    showSuggestions(type) {
        const dropdown = type === 'department' ? 
            this.elements.departmentDropdown : 
            this.elements.provinceDropdown;
        
        dropdown.style.display = 'block';
    }

    hideSuggestions(type) {
        const dropdown = type === 'department' ? 
            this.elements.departmentDropdown : 
            this.elements.provinceDropdown;
        
        dropdown.style.display = 'none';
        this.state.activeSuggestionIndex = -1;
    }

    showLoadingState(type) {
        const loadingEl = type === 'department' ? 
            this.elements.departmentLoading : 
            this.elements.provinceLoading;
        
        const dropdown = type === 'department' ? 
            this.elements.departmentDropdown : 
            this.elements.provinceDropdown;

        dropdown.innerHTML = '';
        dropdown.appendChild(loadingEl);
        loadingEl.style.display = 'block';
        dropdown.style.display = 'block';
    }

    hideLoadingState(type) {
        const loadingEl = type === 'department' ? 
            this.elements.departmentLoading : 
            this.elements.provinceLoading;
        
        loadingEl.style.display = 'none';
    }

    async makeRequest(url) {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        return await response.json();
    }

    // Métodos públicos
    getDepartment() {
        return this.state.selectedDepartment;
    }

    getProvince() {
        return this.state.selectedProvince;
    }

    getSelectedData() {
        return {
            department: this.state.selectedDepartment,
            province: this.state.selectedProvince
        };
    }

    reset() {
        this.elements.departmentInput.value = '';
        this.elements.provinceInput.value = '';
        this.clearDepartmentSelection();
        this.hideSuggestions('department');
        this.hideSuggestions('province');
        
        if (this.config.onClear) {
            this.config.onClear();
        }
    }

    setDepartment(departmentId) {
        if (this.cache.departments) {
            const dept = this.cache.departments.find(d => d.id == departmentId);
            if (dept) {
                this.selectDepartment(dept);
            }
        }
    }

    setProvince(provinceId) {
        if (this.state.selectedDepartment && this.cache.provinces.has(this.state.selectedDepartment.id)) {
            const provinces = this.cache.provinces.get(this.state.selectedDepartment.id);
            const prov = provinces.find(p => p.id == provinceId);
            if (prov) {
                this.selectProvince(prov);
            }
        }
    }

    handleError(message, error) {
        this.log(`❌ ${message}:`, error);
        
        if (this.config.onError) {
            this.config.onError(message, error);
        } else {
            this.showMessage(`${message}: ${error.message}`, 'error');
        }
    }

    showMessage(message, type = 'info') {
        // Sistema de notificaciones mejorado
        let messageEl = document.getElementById('advanced-location-message');
        
        if (!messageEl) {
            messageEl = document.createElement('div');
            messageEl.id = 'advanced-location-message';
            messageEl.style.cssText = `
                position: fixed;
                top: 80px;
                right: 20px;
                padding: 12px 16px;
                border-radius: 8px;
                z-index: 9999;
                max-width: 350px;
                font-size: 14px;
                transition: all 0.3s ease;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            `;
            document.body.appendChild(messageEl);
        }

        const styles = {
            success: 'background: #d4edda; color: #155724; border-left: 4px solid #28a745;',
            error: 'background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545;',
            warning: 'background: #fff3cd; color: #856404; border-left: 4px solid #ffc107;',
            info: 'background: #d1ecf1; color: #0c5460; border-left: 4px solid #17a2b8;'
        };

        messageEl.style.cssText += styles[type] || styles.info;
        messageEl.textContent = message;

        setTimeout(() => {
            if (messageEl && messageEl.parentNode) {
                messageEl.remove();
            }
        }, 4000);
    }

    log(...args) {
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            console.log('[AdvancedLocationAutocomplete]', ...args);
        }
    }

    destroy() {
        // Limpiar timeouts
        Object.values(this.timeouts).forEach(timeout => {
            if (timeout) clearTimeout(timeout);
        });

        // Limpiar cache
        this.cache.departments = null;
        this.cache.provinces.clear();
        this.cache.searchResults.clear();

        // Remover mensajes
        const messageEl = document.getElementById('advanced-location-message');
        if (messageEl) {
            messageEl.remove();
        }
    }
}

// CSS para animaciones
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .autocomplete-input:focus {
        border-color: #007bff !important;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1) !important;
        outline: none !important;
    }
    
    .suggestion-item.active {
        background-color: #e3f2fd !important;
        border-left: 3px solid #007bff !important;
    }
    
    .autocomplete-dropdown {
        scrollbar-width: thin;
        scrollbar-color: #ccc transparent;
    }
    
    .autocomplete-dropdown::-webkit-scrollbar {
        width: 6px;
    }
    
    .autocomplete-dropdown::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .autocomplete-dropdown::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }
`;
document.head.appendChild(style);

// Exportar para uso global
window.AdvancedLocationAutocomplete = AdvancedLocationAutocomplete;
