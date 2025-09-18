/**
 * Location Handler - Manejo dinámico de departamentos y provincias del Perú
 * Para formularios de registro de usuarios con información empresarial
 * Versión 2.0 - Utiliza API backend para datos actualizados
 */

class LocationHandler {
    constructor() {
        this.apiBaseUrl = '/api/v1/locations';
        this.departamentos = [];
        this.cache = {
            departamentos: null,
            provincias: {}
        };
        
        this.init();
    }

    async init() {
        // Buscar elementos de departamento y provincia en la página
        this.departamentoSelect = document.getElementById('departamento');
        this.provinciaSelect = document.getElementById('provincia');

        if (this.departamentoSelect && this.provinciaSelect) {
            await this.loadDepartamentos();
            this.setupEventListeners();
        }
    }

    async loadDepartamentos() {
        try {
            if (this.cache.departamentos) {
                return this.cache.departamentos;
            }

            console.log('Cargando departamentos desde API...');
            const response = await fetch(`${this.apiBaseUrl}/departamentos`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success && result.data) {
                this.cache.departamentos = result.data;
                this.populateDepartamentosSelect(result.data);
                console.log('Departamentos cargados exitosamente:', result.data.length);
                return result.data;
            } else {
                throw new Error(result.message || 'Error al cargar departamentos');
            }
            
        } catch (error) {
            console.error('Error cargando departamentos:', error);
            this.showError('Error al cargar departamentos. Usando datos locales como respaldo.');
            this.loadFallbackDepartamentos();
        }
    }

    populateDepartamentosSelect(departamentos) {
        // Mantener la opción por defecto
        const defaultOption = this.departamentoSelect.querySelector('option[value=""]');
        const oldValue = this.departamentoSelect.value;
        
        // Limpiar opciones actuales excepto la por defecto
        this.departamentoSelect.innerHTML = '';
        if (defaultOption) {
            this.departamentoSelect.appendChild(defaultOption);
        } else {
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'Seleccionar departamento...';
            this.departamentoSelect.appendChild(option);
        }
        
        // Agregar departamentos ordenados alfabéticamente
        departamentos
            .sort((a, b) => a.nombre.localeCompare(b.nombre))
            .forEach(departamento => {
                const option = document.createElement('option');
                option.value = departamento.nombre;
                option.textContent = departamento.nombre;
                option.dataset.departamentoId = departamento.id;
                
                if (oldValue && oldValue === departamento.nombre) {
                    option.selected = true;
                }
                
                this.departamentoSelect.appendChild(option);
            });
    }

    loadFallbackDepartamentos() {
        // Datos de respaldo para departamentos
        const fallbackDepartamentos = [
            'Amazonas', 'Áncash', 'Apurímac', 'Arequipa', 'Ayacucho', 'Cajamarca', 
            'Callao', 'Cusco', 'Huancavelica', 'Huánuco', 'Ica', 'Junín', 
            'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 
            'Moquegua', 'Pasco', 'Piura', 'Puno', 'San Martín', 'Tacna', 'Tumbes', 'Ucayali'
        ];

        fallbackDepartamentos.forEach((nombre, index) => {
            const option = document.createElement('option');
            option.value = nombre;
            option.textContent = nombre;
            option.dataset.departamentoId = index + 1; // ID temporal
            this.departamentoSelect.appendChild(option);
        });
    }

    setupEventListeners() {
        this.departamentoSelect.addEventListener('change', async (event) => {
            const departamentoNombre = event.target.value;
            const departamentoId = event.target.selectedOptions[0]?.dataset?.departamentoId;
            
            if (departamentoNombre && departamentoId) {
                await this.updateProvincias(departamentoId, departamentoNombre);
            } else {
                this.clearProvincias();
            }
        });

        // Si hay valores previos (old values), cargar las provincias correspondientes
        if (this.departamentoSelect.value) {
            const selectedOption = this.departamentoSelect.selectedOptions[0];
            const departamentoId = selectedOption?.dataset?.departamentoId;
            if (departamentoId) {
                this.updateProvincias(departamentoId, this.departamentoSelect.value);
            }
        }
    }

    async updateProvincias(departamentoId, departamentoNombre) {
        try {
            // Mostrar indicador de carga
            this.showLoadingProvincias();
            
            // Verificar caché
            if (this.cache.provincias[departamentoId]) {
                this.populateProvinciasSelect(this.cache.provincias[departamentoId]);
                return;
            }
            
            console.log(`Cargando provincias para departamento ${departamentoNombre} (ID: ${departamentoId})...`);
            
            const response = await fetch(`${this.apiBaseUrl}/provincias/departamento/${departamentoId}`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success && result.data) {
                // Guardar en caché
                this.cache.provincias[departamentoId] = result.data;
                this.populateProvinciasSelect(result.data);
                console.log(`Provincias cargadas exitosamente para ${departamentoNombre}:`, result.data.length);
            } else {
                throw new Error(result.message || 'Error al cargar provincias');
            }
            
        } catch (error) {
            console.error('Error cargando provincias:', error);
            this.showError(`Error al cargar provincias para ${departamentoNombre}. Usando datos locales como respaldo.`);
            this.loadFallbackProvincias(departamentoNombre);
        }
    }

    populateProvinciasSelect(provincias) {
        // Limpiar opciones actuales
        this.provinciaSelect.innerHTML = '<option value="">Seleccionar provincia...</option>';
        
        // Obtener valor anterior si existe
        const oldProvincia = this.getOldValue('provincia');
        
        // Agregar provincias ordenadas alfabéticamente
        provincias
            .sort((a, b) => a.nombre.localeCompare(b.nombre))
            .forEach(provincia => {
                const option = document.createElement('option');
                option.value = provincia.nombre;
                option.textContent = provincia.nombre;
                option.dataset.provinciaId = provincia.id;
                
                // Mantener valor seleccionado si existe
                if (oldProvincia && oldProvincia === provincia.nombre) {
                    option.selected = true;
                }
                
                this.provinciaSelect.appendChild(option);
            });
        
        this.provinciaSelect.disabled = false;
        this.hideLoadingProvincias();
    }

    loadFallbackProvincias(departamentoNombre) {
        // Datos de respaldo para las provincias más comunes
        const fallbackProvincias = {
            'La Libertad': ['Trujillo', 'Ascope', 'Bolívar', 'Chepén', 'Julcán', 'Otuzco', 'Pacasmayo', 'Pataz', 'Sánchez Carrión', 'Santiago de Chuco', 'Gran Chimú', 'Virú'],
            'Lima': ['Lima', 'Barranca', 'Cajatambo', 'Canta', 'Cañete', 'Huaral', 'Huarochirí', 'Huaura', 'Oyón', 'Yauyos'],
            'Arequipa': ['Arequipa', 'Camaná', 'Caravelí', 'Castilla', 'Caylloma', 'Condesuyos', 'Islay', 'La Unión'],
            'Cusco': ['Cusco', 'Acomayo', 'Anta', 'Calca', 'Canas', 'Canchis', 'Chumbivilcas', 'Espinar', 'La Convención', 'Paruro', 'Paucartambo', 'Quispicanchi', 'Urubamba'],
            // Agregar más según necesidad
        };

        const provincias = fallbackProvincias[departamentoNombre] || [];
        
        this.provinciaSelect.innerHTML = '<option value="">Seleccionar provincia...</option>';
        
        provincias.forEach((nombre, index) => {
            const option = document.createElement('option');
            option.value = nombre;
            option.textContent = nombre;
            option.dataset.provinciaId = `fallback-${index}`;
            this.provinciaSelect.appendChild(option);
        });
        
        this.provinciaSelect.disabled = provincias.length === 0;
        this.hideLoadingProvincias();
    }

    clearProvincias() {
        this.provinciaSelect.innerHTML = '<option value="">Seleccionar provincia...</option>';
        this.provinciaSelect.disabled = true;
        this.hideLoadingProvincias();
    }

    showLoadingProvincias() {
        this.provinciaSelect.innerHTML = '<option value="">Cargando provincias...</option>';
        this.provinciaSelect.disabled = true;
    }

    hideLoadingProvincias() {
        // Método para ocultar indicador de carga si es necesario
    }

    showError(message) {
        console.warn('LocationHandler:', message);
        
        // Mostrar notificación visual si existe un contenedor para errores
        const errorContainer = document.getElementById('location-error');
        if (errorContainer) {
            errorContainer.textContent = message;
            errorContainer.style.display = 'block';
            setTimeout(() => {
                errorContainer.style.display = 'none';
            }, 5000);
        }
    }

    getOldValue(fieldName) {
        // Buscar el valor anterior en el input hidden o en localStorage
        const hiddenInput = document.querySelector(`input[name="_old_${fieldName}"]`);
        if (hiddenInput) {
            return hiddenInput.value;
        }
        
        // Alternativamente, buscar en el select mismo
        const select = document.querySelector(`select[name="${fieldName}"]`);
        if (select && select.dataset.oldValue) {
            return select.dataset.oldValue;
        }
        
        return null;
    }

    // Método para obtener todas las provincias de un departamento (API)
    async getProvinciasByDepartamento(departamentoId) {
        try {
            if (this.cache.provincias[departamentoId]) {
                return this.cache.provincias[departamentoId];
            }
            
            const response = await fetch(`${this.apiBaseUrl}/provincias/departamento/${departamentoId}`);
            const result = await response.json();
            
            if (result.success && result.data) {
                this.cache.provincias[departamentoId] = result.data;
                return result.data;
            }
            
            return [];
        } catch (error) {
            console.error('Error obteniendo provincias:', error);
            return [];
        }
    }

    // Método para validar que una provincia pertenece a un departamento
    async validateProvinciaForDepartamento(departamentoId, provinciaId) {
        const provincias = await this.getProvinciasByDepartamento(departamentoId);
        return provincias.some(p => p.id == provinciaId);
    }

    // Método para obtener todos los departamentos
    async getAllDepartamentos() {
        if (this.cache.departamentos) {
            return this.cache.departamentos;
        }
        
        try {
            const response = await fetch(`${this.apiBaseUrl}/departamentos`);
            const result = await response.json();
            
            if (result.success && result.data) {
                this.cache.departamentos = result.data;
                return result.data;
            }
            
            return [];
        } catch (error) {
            console.error('Error obteniendo departamentos:', error);
            return [];
        }
    }

    // Método para buscar ubicaciones
    async searchLocation(query, type = 'both') {
        try {
            const promises = [];
            
            if (type === 'departamentos' || type === 'both') {
                promises.push(
                    fetch(`${this.apiBaseUrl}/departamentos/search?q=${encodeURIComponent(query)}`)
                        .then(r => r.json())
                );
            }
            
            if (type === 'provincias' || type === 'both') {
                promises.push(
                    fetch(`${this.apiBaseUrl}/provincias/search?q=${encodeURIComponent(query)}`)
                        .then(r => r.json())
                );
            }
            
            const results = await Promise.all(promises);
            
            return {
                departamentos: results[0]?.success ? results[0].data : [],
                provincias: results[1]?.success ? results[1].data : []
            };
            
        } catch (error) {
            console.error('Error en búsqueda de ubicaciones:', error);
            return { departamentos: [], provincias: [] };
        }
    }

    // Método para resetear caché
    clearCache() {
        this.cache = {
            departamentos: null,
            provincias: {}
        };
    }
}
// Inicializar cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    window.locationHandler = new LocationHandler();
});

// Exportar para uso en otros scripts si es necesario
window.LocationHandler = LocationHandler;
