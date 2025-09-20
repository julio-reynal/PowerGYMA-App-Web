/**
 * CLIENTES.JS - PowerGYMA
 * JavaScript para la sección de casos de éxito
 */

document.addEventListener('DOMContentLoaded', function() {
    // Forzar carga inmediata de imágenes críticas antes de cualquier lazy loading
    forceCriticalImageLoad();
    
    initCircularProgress();
    initScrollAnimations();
    initCTAInteractions();
});

/**
 * Forzar carga inmediata de imágenes críticas
 */
function forceCriticalImageLoad() {
    const criticalImages = document.querySelectorAll('img.critical');
    criticalImages.forEach(img => {
        // Asegurar que las imágenes críticas no sean procesadas por lazy loading
        if (img.dataset.src && !img.src.startsWith('data:')) {
            // Si ya tiene data-src, restaurar el src original
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        }
        // Remover clase lazy si existe
        img.classList.remove('lazy');
        // Asegurar que se carga inmediatamente
        if (img.loading) {
            img.loading = 'eager';
        }
    });
}

/**
 * Inicializar el progreso circular
 */
function initCircularProgress() {
    const progressElements = document.querySelectorAll('.circular-progress');
    
    progressElements.forEach(element => {
        const percentage = parseInt(element.dataset.percentage) || 0;
        const fill = element.querySelector('.circular-fill');
        
        if (fill) {
            // Calcular el ángulo basado en el porcentaje
            const angle = (percentage / 100) * 360;
            
            // Configurar la animación del progreso circular
            setTimeout(() => {
                fill.style.transform = `rotate(${angle - 90}deg)`;
                fill.style.transition = 'transform 1.5s ease-in-out';
            }, 500);
        }
    });
}

/**
 * Inicializar animaciones al hacer scroll
 */
function initScrollAnimations() {
    // Configurar Intersection Observer para animaciones
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                
                // Animar métricas con contadores
                if (entry.target.classList.contains('estadistica') || 
                    entry.target.classList.contains('metrica')) {
                    animateCounter(entry.target);
                }
            }
        });
    }, observerOptions);

    // Observar elementos que se deben animar
    const elementsToAnimate = document.querySelectorAll(`
        .caso-card,
        .estadistica,
        .metrica,
        .beneficio-card,
        .testimonio-container
    `);

    elementsToAnimate.forEach(el => {
        observer.observe(el);
    });
}

/**
 * Animar contadores numéricos
 */
function animateCounter(element) {
    const valueElement = element.querySelector('.estadistica-valor, .metrica-valor');
    if (!valueElement) return;

    const finalText = valueElement.textContent;
    const hasPercentage = finalText.includes('%');
    const hasK = finalText.includes('k');
    const hasPlus = finalText.includes('+');
    const hasMinus = finalText.includes('-');
    
    // Extraer el número
    let finalValue = parseInt(finalText.replace(/[^\d]/g, '')) || 0;
    
    if (finalValue === 0) return;

    let currentValue = 0;
    const increment = finalValue / 30; // 30 frames para la animación
    const duration = 1500; // 1.5 segundos
    const stepTime = duration / 30;

    const timer = setInterval(() => {
        currentValue += increment;
        
        if (currentValue >= finalValue) {
            currentValue = finalValue;
            clearInterval(timer);
        }

        // Formatear el valor
        let displayValue = Math.floor(currentValue).toString();
        
        if (hasMinus) displayValue = '-' + displayValue;
        if (hasPercentage) displayValue += '%';
        if (hasK) displayValue += 'k';
        if (hasPlus) displayValue += '+';

        valueElement.textContent = displayValue;
    }, stepTime);
}

/**
 * Inicializar interacciones del CTA
 */
function initCTAInteractions() {
    const ctaButton = document.querySelector('.cta-button');
    
    if (ctaButton) {
        // Efecto hover mejorado
        ctaButton.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 8px 25px rgba(250, 140, 22, 0.3)';
        });

        ctaButton.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });

        // Efecto de click
        ctaButton.addEventListener('click', function(e) {
            // Aquí puedes agregar la lógica para abrir un modal de contacto
            // o redirigir a una página de contacto
            console.log('Solicitar consulta gratuita');
            
            // Efecto visual de click
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'translateY(-2px)';
            }, 150);
        });
    }
}

/**
 * Utilidad para smooth scroll a elementos
 */
function smoothScrollTo(element) {
    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }
}

/**
 * Añadir clases CSS para animaciones
 */
const style = document.createElement('style');
style.textContent = `
    .caso-card,
    .estadistica,
    .metrica,
    .beneficio-card,
    .testimonio-container {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .caso-card.animate-in,
    .estadistica.animate-in,
    .metrica.animate-in,
    .beneficio-card.animate-in,
    .testimonio-container.animate-in {
        opacity: 1;
        transform: translateY(0);
    }

    .cta-button {
        transition: all 0.3s ease;
    }

    .circular-fill {
        border-right-color: #fa8c16;
        border-top-color: #fa8c16;
        border-left-color: transparent;
        border-bottom-color: transparent;
    }

    /* Efecto de gradiente en el progreso circular */
    .circular-progress[data-percentage="30"] .circular-fill {
        transform: rotate(18deg); /* 30% de 360° - 90° offset */
    }

    .circular-progress[data-percentage="40"] .circular-fill {
        transform: rotate(54deg); /* 40% de 360° - 90° offset */
    }

    /* Animación de entrada escalonada para las tarjetas */
    .caso-card:nth-child(1) {
        transition-delay: 0.1s;
    }

    .caso-card:nth-child(2) {
        transition-delay: 0.2s;
    }

    .beneficio-card:nth-child(1) {
        transition-delay: 0.1s;
    }

    .beneficio-card:nth-child(2) {
        transition-delay: 0.2s;
    }

    .beneficio-card:nth-child(3) {
        transition-delay: 0.3s;
    }

    .beneficio-card:nth-child(4) {
        transition-delay: 0.4s;
    }

    /* Animación del testimonio */
    .testimonio-container.animate-in .testimonio-quote {
        animation: fadeInScale 0.8s ease 0.5s both;
    }

    .testimonio-container.animate-in .testimonio-texto {
        animation: fadeInUp 0.8s ease 0.7s both;
    }

    .testimonio-container.animate-in .testimonio-autor {
        animation: fadeInUp 0.8s ease 0.9s both;
    }

    .testimonio-container.animate-in .testimonio-logo {
        animation: fadeInUp 0.8s ease 1.1s both;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Efectos adicionales para mejorar la interactividad */
    .beneficio-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(250, 140, 22, 0.1);
        border-color: rgba(250, 140, 22, 0.3);
        transition: all 0.3s ease;
    }

    .caso-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }
`;

document.head.appendChild(style);