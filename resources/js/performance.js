// Utilidades de performance para lazy loading y preloading
export class PerformanceOptimizer {
    constructor() {
        this.init();
    }

    init() {
        this.enableLazyLoading();
        this.preloadCriticalResources();
        this.optimizeImages();
    }

    // Lazy loading para imágenes
    enableLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    // Preload de recursos críticos
    preloadCriticalResources() {
        // Preload fuentes críticas
        const fontLink = document.createElement('link');
        fontLink.rel = 'preload';
        fontLink.as = 'font';
        fontLink.type = 'font/woff2';
        fontLink.crossOrigin = 'anonymous';
        fontLink.href = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap';
        document.head.appendChild(fontLink);
    }

    // Optimización de imágenes con WebP
    optimizeImages() {
        if (this.supportsWebP()) {
            document.querySelectorAll('img').forEach(img => {
                const src = img.src;
                if (src && !src.includes('.webp')) {
                    // Intentar cargar versión WebP si existe
                    const webpSrc = src.replace(/\.(jpg|jpeg|png)$/i, '.webp');
                    const testImg = new Image();
                    testImg.onload = () => {
                        img.src = webpSrc;
                    };
                    testImg.src = webpSrc;
                }
            });
        }
    }

    // Verificar soporte WebP
    supportsWebP() {
        const canvas = document.createElement('canvas');
        canvas.width = 1;
        canvas.height = 1;
        return canvas.toDataURL('image/webp').indexOf('data:image/webp') === 0;
    }

    // Lazy loading para componentes JavaScript
    static async loadComponent(componentName) {
        try {
            const module = await import(`./components/${componentName}.js`);
            return module.default || module;
        } catch (error) {
            console.warn(`Failed to load component: ${componentName}`, error);
            return null;
        }
    }

    // Cache de recursos con Service Worker (básico)
    static registerServiceWorker() {
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
                .then(registration => {
                    console.log('SW registered:', registration);
                })
                .catch(registrationError => {
                    console.log('SW registration failed:', registrationError);
                });
        }
    }
}

// Auto-inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new PerformanceOptimizer();
    });
} else {
    new PerformanceOptimizer();
}

export default PerformanceOptimizer;