/**
 * CONTACTO FIGMA COMPONENT - JAVASCRIPT
 * Maneja la funcionalidad del formulario de contacto
 */

document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar el formulario
    const contactForm = document.querySelector('.contact-form-new');
    
    if (!contactForm) {
        console.warn('Formulario de contacto no encontrado');
        return;
    }
    
    // Validación en tiempo real
    const inputs = contactForm.querySelectorAll('.form-input-new, .form-textarea-new');
    
    inputs.forEach(input => {
        // Eliminar placeholder al hacer focus
        input.addEventListener('focus', function() {
            this.setAttribute('data-placeholder', this.placeholder);
            this.placeholder = '';
        });
        
        // Restaurar placeholder al salir si está vacío
        input.addEventListener('blur', function() {
            if (this.value === '') {
                this.placeholder = this.getAttribute('data-placeholder') || '';
            }
        });
        
        // Validación básica
        input.addEventListener('input', function() {
            validateInput(this);
        });
    });
    
    // Envío del formulario
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar todos los campos
        let isValid = true;
        const requiredInputs = contactForm.querySelectorAll('[required]');
        
        requiredInputs.forEach(input => {
            if (!validateInput(input)) {
                isValid = false;
            }
        });
        
        if (isValid) {
            submitForm(contactForm);
        } else {
            showNotification('Por favor, completa todos los campos requeridos', 'error');
        }
    });
    
    /**
     * Validar un input individual
     */
    function validateInput(input) {
        const value = input.value.trim();
        const type = input.type;
        let isValid = true;
        
        // Si es requerido y está vacío
        if (input.hasAttribute('required') && value === '') {
            isValid = false;
            input.style.borderColor = '#ff4d4f';
        } 
        // Validar email
        else if (type === 'email' && value !== '') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            isValid = emailRegex.test(value);
            input.style.borderColor = isValid ? '#db7f13' : '#ff4d4f';
        } 
        // Campo válido
        else if (value !== '') {
            input.style.borderColor = '#db7f13';
        } 
        // Campo vacío pero no requerido
        else {
            input.style.borderColor = '#000000';
        }
        
        return isValid;
    }
    
    /**
     * Enviar el formulario
     */
    function submitForm(form) {
        const submitButton = form.querySelector('.submit-button-new');
        const originalText = submitButton.textContent;
        
        // Deshabilitar botón y mostrar loading
        submitButton.disabled = true;
        submitButton.textContent = 'Enviando...';
        submitButton.style.opacity = '0.7';
        
        // Obtener datos del formulario
        const formData = new FormData(form);
        
        // Simular envío (aquí deberías hacer la petición real)
        setTimeout(() => {
            // Aquí va tu lógica de envío real con fetch o axios
            // Por ahora simulamos éxito
            console.log('Datos del formulario:', Object.fromEntries(formData));
            
            // Mostrar mensaje de éxito
            showNotification('¡Mensaje enviado correctamente! Nos pondremos en contacto contigo pronto.', 'success');
            
            // Resetear formulario
            form.reset();
            
            // Resetear bordes de inputs
            const inputs = form.querySelectorAll('.form-input-new, .form-textarea-new');
            inputs.forEach(input => {
                input.style.borderColor = '#000000';
            });
            
            // Restaurar botón
            submitButton.disabled = false;
            submitButton.textContent = originalText;
            submitButton.style.opacity = '1';
            
        }, 1500);
    }
    
    /**
     * Mostrar notificación
     */
    function showNotification(message, type = 'info') {
        // Crear elemento de notificación
        const notification = document.createElement('div');
        notification.className = `contact-notification contact-notification-${type}`;
        notification.textContent = message;
        
        // Estilos
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: ${type === 'success' ? '#10b981' : '#ef4444'};
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 500;
            animation: slideIn 0.3s ease-out;
            max-width: 400px;
        `;
        
        // Agregar animación
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
        
        // Agregar al body
        document.body.appendChild(notification);
        
        // Remover después de 5 segundos
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    }
    
    // Animación smooth scroll para enlaces del mapa
    const mapLinks = document.querySelectorAll('.contact-info-item a');
    mapLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.hash !== '') {
                e.preventDefault();
                const hash = this.hash;
                const target = document.querySelector(hash);
                
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    
    console.log('✅ Componente de contacto inicializado correctamente');
});
