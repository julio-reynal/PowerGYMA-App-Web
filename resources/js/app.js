import './bootstrap';
import PerformanceOptimizer from './performance';

// Inicializar optimizaciones de rendimiento
document.addEventListener('DOMContentLoaded', () => {
    // Registrar Service Worker para caching
    PerformanceOptimizer.registerServiceWorker();
    
    // Lazy loading de componentes no críticos
    setTimeout(() => {
        // Cargar componentes secundarios después del contenido crítico
        const secondaryComponents = document.querySelectorAll('[data-component]');
        secondaryComponents.forEach(async (element) => {
            const componentName = element.dataset.component;
            if (componentName) {
                const component = await PerformanceOptimizer.loadComponent(componentName);
                if (component) {
                    // Inicializar componente si tiene método init
                    if (typeof component.init === 'function') {
                        component.init(element);
                    }
                }
            }
        });
    }, 100); // Delay pequeño para no bloquear el render inicial
});

// Optimización de imágenes lazy loading
document.addEventListener('DOMContentLoaded', () => {
    // Convertir imágenes regulares a lazy loading
    const images = document.querySelectorAll('img:not([data-src])');
    images.forEach(img => {
        if (img.src && !img.classList.contains('critical')) {
            const dataSrc = img.src;
            img.dataset.src = dataSrc;
            img.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB2aWV3Qm94PSIwIDAgMSAxIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxyZWN0IHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InRyYW5zcGFyZW50Ii8+PC9zdmc+';
            img.classList.add('lazy');
        }
    });
});
