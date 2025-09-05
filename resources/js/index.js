// =====================================
// INDEX PAGE JAVASCRIPT - POWER GYMA
// =====================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('Power GYMA - Página de inicio cargada');
    
    // Animación para el logo
    const logo = document.querySelector('.logo');
    if (logo) {
        logo.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1) rotate(5deg)';
        });
        
        logo.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
        });
    }
    
    // Efecto de carga para los botones
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Añadir efecto de loading si es necesario
            if (!this.classList.contains('secondary')) {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            }
        });
    });
    
    // Verificar estado de conexión (opcional)
    if (navigator.onLine) {
        console.log('Conectado a internet');
    } else {
        console.log('Sin conexión a internet');
        // Mostrar mensaje de sin conexión si es necesario
    }
    
    // Precarga de recursos críticos
    const preloadLogin = () => {
        const link = document.createElement('link');
        link.rel = 'prefetch';
        link.href = '/login';
        document.head.appendChild(link);
    };
    
    // Precargar página de login después de 2 segundos
    setTimeout(preloadLogin, 2000);
    
    // Animación suave al hacer scroll (si hay contenido)
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observar elementos con animación
    const animatedElements = document.querySelectorAll('.welcome-card');
    animatedElements.forEach(el => observer.observe(el));
});
