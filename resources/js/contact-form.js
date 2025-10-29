// ============================================================
// ARCHIVO DESACTIVADO
// ============================================================
// Este archivo ha sido desactivado para evitar notificaciones duplicadas.
// El manejo del formulario de contacto ahora se realiza completamente
// en el script inline de index.blade.php
// ============================================================

console.log('📝 contact-form.js: Archivo desactivado - El formulario se maneja en index.blade.php');

// Mantener las animaciones CSS que podrían ser útiles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }
`;
document.head.appendChild(style);
