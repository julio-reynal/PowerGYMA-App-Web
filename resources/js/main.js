// Main.js - PowerGYMA Website Functionality

document.addEventListener('DOMContentLoaded', function() {
    initializeWebsite();
});

function initializeWebsite() {
    // Initialize all main functionality
    initializeAnimations();
    initializeServices();
    initializeParticles();
    initializeScrollEffects();
    initializeCTAButtons();
    initializeTestimonials();
}

// Animation on Scroll
function initializeAnimations() {
    // Create intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    // Observe all animatable elements
    const animatableElements = document.querySelectorAll(
        '.benefit-card, .step, .service-card, .stat, .client-logo, .testimonial-content'
    );
    
    animatableElements.forEach(el => {
        observer.observe(el);
    });
}

// Services Section Interactive Menu
function initializeServices() {
    const serviceItems = document.querySelectorAll('.service-item');
    const serviceShowcase = document.querySelector('.service-showcase');
    
    // Service data - Updated with correct images according to Figma design
    const servicesData = {
        smartpeak: {
            title: 'Plan SmartPeak',
            description: 'Optimizamos tus picos de consumo energético para reducir penalizaciones y costes asociados.',
            image: 'assets/images/5ba4c4d57238514056e49d7be097a785436ad1ab.png'
        },
        picocero: {
            title: 'Plan Pico Cero',
            description: 'Eliminamos completamente los picos de consumo mediante gestión inteligente de cargas y sistemas de almacenamiento.',
            image: 'assets/images/f53e7d9bd5a2c27f460eab0d48d56819a72d6b94.png'
        },
        smarttarifa: {
            title: 'Plan Smart Tarifa',
            description: 'Optimizamos el uso energético según las tarifas horarias para maximizar el ahorro y eficiencia.',
            image: 'assets/images/97f02ab9639ce7dbf4e3a155db14b6f38706498f.png'
        },
        consulting: {
            title: 'Business Consulting',
            description: 'Consultoría estratégica personalizada para transformar tu gestión energética empresarial de manera integral.',
            image: 'assets/images/0a5bd49d5d4a6bbbd8de3622e1a183f193644212.png'
        }
    };
    
    serviceItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all items and reset background
            serviceItems.forEach(si => {
                si.classList.remove('active');
                si.style.background = ''; // Reset inline styles
            });
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Get service data
            const serviceKey = this.getAttribute('data-service');
            const serviceData = servicesData[serviceKey];
            
            if (serviceData && serviceShowcase) {
                updateServiceShowcase(serviceData);
            }
        });
        
        // Add hover effects - only for non-active items
        item.addEventListener('mouseenter', function() {
            if (!this.classList.contains('active')) {
                this.style.background = 'rgba(0, 0, 0, 0.2)';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active')) {
                this.style.background = '';
            }
        });
    });
}

function updateServiceShowcase(serviceData) {
    const serviceShowcase = document.querySelector('.service-showcase');
    
    if (!serviceShowcase) return;
    
    // Add smooth transition effect
    serviceShowcase.style.opacity = '0';
    serviceShowcase.style.transform = 'translateX(20px)';
    serviceShowcase.style.transition = 'all 0.3s ease';
    
    setTimeout(() => {
        serviceShowcase.innerHTML = `
            <div class="service-card">
                <div class="service-image">
                    <img src="${serviceData.image}" alt="${serviceData.title}">
                </div>
                <div class="service-info">
                    <h3>${serviceData.title}</h3>
                    <p>${serviceData.description}</p>
                    <a href="#" class="service-link">
                        Ver más
                        <img src="assets/icons/a6423256919ef67ad6fb02dfe2329e77a12fee54.svg" alt="arrow">
                    </a>
                </div>
            </div>
        `;
        
        // Animate in with perfect Figma-like transition
        serviceShowcase.style.opacity = '1';
        serviceShowcase.style.transform = 'translateX(0)';
        
        // Add click handler to the new service link
        const newServiceLink = serviceShowcase.querySelector('.service-link');
        if (newServiceLink) {
            newServiceLink.addEventListener('click', function(e) {
                e.preventDefault();
                // Scroll to contact section or show modal
                const contactSection = document.querySelector('.contact-section-figma');
                if (contactSection) {
                    contactSection.scrollIntoView({ behavior: 'smooth' });
                } else {
                    showContactModal();
                }
            });
        }
    }, 200);
}

// Particle Effects for Hero Section
function initializeParticles() {
    const particlesContainer = document.querySelector('.particles-container');
    
    if (!particlesContainer) return;
    
    // Create floating particles
    for (let i = 0; i < 20; i++) {
        createParticle(particlesContainer);
    }
}

function createParticle(container) {
    const particle = document.createElement('div');
    particle.className = 'particle';
    
    // Random properties
    const size = Math.random() * 4 + 2;
    const left = Math.random() * 100;
    const animationDuration = Math.random() * 10 + 10;
    const delay = Math.random() * 5;
    
    particle.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        background: ${Math.random() > 0.5 ? '#fe9213' : '#025ccd'};
        border-radius: 50%;
        left: ${left}%;
        top: 100%;
        opacity: ${Math.random() * 0.6 + 0.2};
        animation: floatUp ${animationDuration}s linear infinite;
        animation-delay: ${delay}s;
    `;
    
    container.appendChild(particle);
    
    // Remove particle after animation
    setTimeout(() => {
        if (particle.parentNode) {
            particle.parentNode.removeChild(particle);
            createParticle(container); // Create new particle
        }
    }, (animationDuration + delay) * 1000);
}

// Scroll Effects
function initializeScrollEffects() {
    // Parallax effect for hero background
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.hero-background');
        
        parallaxElements.forEach(el => {
            const speed = 0.5;
            el.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
    
    // Update stats counter animation
    const stats = document.querySelectorAll('.stat-number');
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    stats.forEach(stat => {
        statsObserver.observe(stat);
    });
}

function animateCounter(element) {
    const target = parseInt(element.textContent);
    const duration = 2000;
    const start = 0;
    const increment = target / (duration / 16);
    let current = start;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        
        // Format number
        if (element.textContent.includes('%')) {
            element.textContent = Math.floor(current) + '%';
        } else if (element.textContent.includes('+')) {
            element.textContent = Math.floor(current) + '+';
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// CTA Buttons Functionality
function initializeCTAButtons() {
    const ctaButtons = document.querySelectorAll('.btn-primary, .btn-secondary');
    
    ctaButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Handle specific button actions
            const buttonText = this.textContent.trim().toLowerCase();
            
            if (buttonText.includes('contacta') || buttonText.includes('consulta')) {
                e.preventDefault();
                showContactModal();
            } else if (buttonText.includes('servicios')) {
                e.preventDefault();
                document.querySelector('.services-section').scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
}

function showContactModal() {
    // Create modal overlay
    const modalOverlay = document.createElement('div');
    modalOverlay.className = 'modal-overlay';
    modalOverlay.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h3>Contacta con nuestros expertos</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <form class="contact-form">
                    <div class="form-group">
                        <label for="name">Nombre completo</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="company">Empresa</label>
                        <input type="text" id="company" name="company">
                    </div>
                    <div class="form-group">
                        <label for="message">Mensaje</label>
                        <textarea id="message" name="message" rows="4" placeholder="Cuéntanos sobre tu proyecto energético..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar consulta</button>
                </form>
            </div>
        </div>
    `;
    
    document.body.appendChild(modalOverlay);
    document.body.style.overflow = 'hidden';
    
    // Modal close functionality
    const closeBtn = modalOverlay.querySelector('.modal-close');
    closeBtn.addEventListener('click', closeModal);
    
    modalOverlay.addEventListener('click', function(e) {
        if (e.target === modalOverlay) {
            closeModal();
        }
    });
    
    // Form submission
    const form = modalOverlay.querySelector('.contact-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        // Handle form submission here
        alert('Gracias por tu consulta. Nos pondremos en contacto contigo pronto.');
        closeModal();
    });
    
    function closeModal() {
        modalOverlay.remove();
        document.body.style.overflow = '';
    }
}

// Testimonials Rotation
function initializeTestimonials() {
    const testimonials = [
        {
            quote: "Gracias a POWERGYMA redujimos nuestros costos de energía en un 32% el primer año. Su sistema de predicción nos permite planificar nuestra producción de manera mucho más eficiente.",
            author: "Gerente de Operaciones, Empresa XYZ"
        },
        {
            quote: "La implementación fue rápida y sin interrupciones. Los resultados se vieron desde el primer mes con una reducción significativa en nuestras facturas energéticas.",
            author: "Director Técnico, Industrias ABC"
        },
        {
            quote: "El equipo de POWERGYMA no solo nos ayudó a reducir costos, sino que nos enseñó a optimizar nuestros procesos de manera sostenible.",
            author: "CEO, Manufacturas DEF"
        }
    ];
    
    let currentTestimonial = 0;
    const testimonialElement = document.querySelector('.testimonial-content p');
    const authorElement = document.querySelector('.testimonial-content cite');
    
    if (!testimonialElement || !authorElement) return;
    
    function rotateTestimonial() {
        currentTestimonial = (currentTestimonial + 1) % testimonials.length;
        const testimonial = testimonials[currentTestimonial];
        
        // Fade out
        testimonialElement.style.opacity = '0';
        authorElement.style.opacity = '0';
        
        setTimeout(() => {
            testimonialElement.textContent = testimonial.quote;
            authorElement.textContent = `- ${testimonial.author}`;
            
            // Fade in
            testimonialElement.style.opacity = '1';
            authorElement.style.opacity = '1';
        }, 300);
    }
    
    // Rotate testimonials every 8 seconds
    setInterval(rotateTestimonial, 8000);
}

// Add CSS for animations and modal
const style = document.createElement('style');
style.textContent = `
    @keyframes floatUp {
        0% {
            transform: translateY(0);
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        100% {
            transform: translateY(-100vh);
            opacity: 0;
        }
    }
    
    .animate-in {
        animation: fadeInUp 0.8s ease-out;
    }
    
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        padding: 2rem;
    }
    
    .modal-content {
        background: white;
        border-radius: 1rem;
        max-width: 500px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .modal-header h3 {
        margin: 0;
        color: #025ccd;
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 2rem;
        cursor: pointer;
        color: #6b7280;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #ffffffff;
    }
    
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }
    
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #fe9213;
        box-shadow: 0 0 0 3px rgba(254, 146, 19, 0.1);
    }
    
    .contact-form .btn {
        width: 100%;
        margin-top: 1rem;
    }
`;

document.head.appendChild(style);

// Contact Form Functionality
function initializeContactForm() {
    const contactForm = document.querySelector('.contact-form-figma') || document.querySelector('.contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(contactForm);
            const data = {};
            
            // Convert FormData to object
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }
            
            // Get form values manually for inputs without names
            data['full-name'] = document.getElementById('full-name').value;
            data['company-name'] = document.getElementById('company-name').value;
            data['email'] = document.getElementById('email').value;
            data['phone'] = document.getElementById('phone').value;
            data['industrial-sector'] = document.getElementById('industrial-sector').value;
            data['estimated-budget'] = document.getElementById('estimated-budget').value;
            data['help-text'] = document.getElementById('help-text').value;
            
            // Get radio button value
            const queryType = document.querySelector('input[name="query-type"]:checked');
            data['query-type'] = queryType ? queryType.value : '';
            
            // Get checkbox value
            const privacyPolicy = document.getElementById('privacy-policy');
            data['privacy-policy'] = privacyPolicy ? privacyPolicy.checked : false;
            
            // Basic validation
            if (!data['full-name'] || !data['email'] || !data['phone']) {
                showNotification('Por favor, completa todos los campos obligatorios.', 'error');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(data['email'])) {
                showNotification('Por favor, introduce un email válido.', 'error');
                return;
            }
            
            // Privacy policy validation
            if (!data['privacy-policy']) {
                showNotification('Debes aceptar la política de privacidad para continuar.', 'error');
                return;
            }
            
            // Show loading state
            const submitBtn = contactForm.querySelector('.submit-btn-figma') || contactForm.querySelector('.submit-btn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Enviando...';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.7';
            
            // Simulate form submission
            setTimeout(() => {
                showNotification('¡Gracias por tu consulta! Nos pondremos en contacto contigo pronto.', 'success');
                contactForm.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
            }, 2000);
        });
        
        // Add focus effects to form inputs
        const inputs = contactForm.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                const wrapper = this.closest('.input-wrapper') || this.closest('.textarea-wrapper') || this.closest('.select-wrapper');
                if (wrapper) {
                    wrapper.classList.add('focused');
                } else {
                    this.parentElement.classList.add('focused');
                }
            });
            
            input.addEventListener('blur', function() {
                const wrapper = this.closest('.input-wrapper') || this.closest('.textarea-wrapper') || this.closest('.select-wrapper');
                if (wrapper) {
                    wrapper.classList.remove('focused');
                } else {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
        
        // Add custom radio button styling functionality
        const radioOptions = contactForm.querySelectorAll('.radio-option');
        radioOptions.forEach(option => {
            option.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    // Remove checked class from other options in the same group
                    const groupName = radio.name;
                    contactForm.querySelectorAll(`input[name="${groupName}"]`).forEach(r => {
                        r.closest('.radio-option').classList.remove('checked');
                    });
                    this.classList.add('checked');
                }
            });
        });
        
        // Add custom checkbox styling functionality
        const checkboxLabels = contactForm.querySelectorAll('.checkbox-label');
        checkboxLabels.forEach(label => {
            label.addEventListener('click', function(e) {
                e.preventDefault();
                const checkbox = this.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    this.classList.toggle('checked', checkbox.checked);
                }
            });
        });
    }
}

// Notification system
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;
    
    // Add notification styles
    Object.assign(notification.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        backgroundColor: type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6',
        color: 'white',
        padding: '1rem 1.5rem',
        borderRadius: '0.5rem',
        boxShadow: '0 10px 25px rgba(0, 0, 0, 0.2)',
        zIndex: '10000',
        maxWidth: '400px',
        transform: 'translateX(100%)',
        transition: 'transform 0.3s ease'
    });
    
    // Add to page
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Add close functionality
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    });
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Initialize contact form when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit for the page to fully load
    setTimeout(() => {
        initializeContactForm();
        initializeContactFormFigma();
    }, 1000);
});

// Contact Form Figma Functionality
function initializeContactFormFigma() {
    const contactForm = document.querySelector('.contact-form-figma');
    
    if (contactForm) {
        // Add form submission handler
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleContactFormSubmission(this);
        });
        
        // Add focus effects to form inputs
        const inputs = contactForm.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                const wrapper = this.closest('.input-wrapper') || this.closest('.textarea-wrapper') || this.closest('.select-wrapper');
                if (wrapper) {
                    wrapper.classList.add('focused');
                } else {
                    this.parentElement.classList.add('focused');
                }
            });
            
            input.addEventListener('blur', function() {
                const wrapper = this.closest('.input-wrapper') || this.closest('.textarea-wrapper') || this.closest('.select-wrapper');
                if (wrapper) {
                    wrapper.classList.remove('focused');
                } else {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
        
        // Add custom radio button styling functionality
        const radioOptions = contactForm.querySelectorAll('.radio-option');
        radioOptions.forEach(option => {
            option.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    // Remove checked class from other options in the same group
                    const groupName = radio.name;
                    contactForm.querySelectorAll(`input[name="${groupName}"]`).forEach(r => {
                        r.closest('.radio-option').classList.remove('checked');
                    });
                    this.classList.add('checked');
                }
            });
        });
        
        // Add custom checkbox styling functionality
        const checkboxLabels = contactForm.querySelectorAll('.checkbox-label');
        checkboxLabels.forEach(label => {
            label.addEventListener('click', function(e) {
                e.preventDefault();
                const checkbox = this.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    this.classList.toggle('checked', checkbox.checked);
                }
            });
        });

        // Add interactive animations to form elements
        addFormAnimations(contactForm);
    }
}

function handleContactFormSubmission(form) {
    // Get form data
    const formData = new FormData(form);
    const data = {};
    
    // Convert FormData to object
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    // Get specific field values
    const fullName = form.querySelector('input[name="fullName"]')?.value;
    const companyName = form.querySelector('input[name="companyName"]')?.value;
    const email = form.querySelector('input[name="email"]')?.value;
    const phone = form.querySelector('input[name="phone"]')?.value;
    const industry = form.querySelector('select[name="industry"]')?.value;
    const budget = form.querySelector('input[name="budget"]')?.value;
    const message = form.querySelector('textarea[name="message"]')?.value;
    
    // Get radio button value
    const consultType = form.querySelector('input[name="consultType"]:checked')?.value;
    
    // Get checkbox value
    const privacyPolicy = form.querySelector('input[name="privacyPolicy"]')?.checked;
    
    // Basic validation
    if (!fullName || !email || !phone) {
        showNotification('Por favor, completa todos los campos obligatorios (Nombre, Email y Teléfono).', 'error');
        return;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showNotification('Por favor, introduce un email válido.', 'error');
        return;
    }
    
    // Privacy policy validation
    if (!privacyPolicy) {
        showNotification('Debes aceptar la política de privacidad para continuar.', 'error');
        return;
    }
    
    // Show loading state
    const submitBtn = form.querySelector('.submit-btn-figma');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Enviando...';
    submitBtn.disabled = true;
    submitBtn.style.opacity = '0.7';
    
    // Simulate form submission
    setTimeout(() => {
        showNotification('¡Gracias por tu consulta! Nos pondremos en contacto contigo en las próximas 24 horas.', 'success');
        form.reset();
        
        // Reset form state
        form.querySelectorAll('.radio-option').forEach(option => option.classList.remove('checked'));
        form.querySelectorAll('.checkbox-label').forEach(label => label.classList.remove('checked'));
        
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
        
        // Scroll to top of form
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 2000);
}

function addFormAnimations(form) {
    // Add floating label effect
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        // Add input animation on type
        input.addEventListener('input', function() {
            if (this.value.length > 0) {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });
        
        // Add smooth focus transition
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'transform 0.2s ease';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
    
    // Add button hover effects
    const submitBtn = form.querySelector('.submit-btn-figma');
    if (submitBtn) {
        submitBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.05)';
        });
        
        submitBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    }
}
