// Components.js - Load Header and Footer Components

document.addEventListener('DOMContentLoaded', function() {
    // Initialize components since they're now embedded
    initializeHeader();
    initializeFooter();
});

function initializeComponents() {
    // Initialize all components
    initializeHeader();
    initializeFooter();
}

function initializeHeader() {
    const header = document.querySelector('header');
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mainNav = document.querySelector('.main-nav');
    const navItems = document.querySelectorAll('.nav-item a');
    
    // Header scroll effect - Optimizado para el diseño Figma
    let scrollTimeout = null;
    let lastScrollY = window.scrollY;
    
    function handleScroll() {
        const currentScrollY = window.scrollY;
        
        // Cancelar timeout anterior si existe
        if (scrollTimeout) {
            clearTimeout(scrollTimeout);
        }
        
        // Aplicar clase scrolled cuando se pase de 50px
        if (currentScrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        // Guardar la posición actual
        lastScrollY = currentScrollY;
        
        // Debounce para optimizar performance
        scrollTimeout = setTimeout(() => {
            // Efectos adicionales después del scroll
            if (currentScrollY > 50) {
                header.style.transform = 'translateY(0)';
            }
        }, 100);
    }
    
    // Usar requestAnimationFrame para scroll suave
    let ticking = false;
    
    function requestScrollUpdate() {
        if (!ticking) {
            requestAnimationFrame(() => {
                handleScroll();
                ticking = false;
            });
            ticking = true;
        }
    }
    
    // Agregar listener de scroll con throttling
    window.addEventListener('scroll', requestScrollUpdate, { passive: true });
    
    // Inicializar estado del header
    handleScroll();
    
    // Mobile menu toggle
    if (mobileMenuBtn && mainNav) {
        mobileMenuBtn.addEventListener('click', function() {
            mainNav.classList.toggle('mobile-open');
            
            // Animate hamburger menu
            const spans = mobileMenuBtn.querySelectorAll('span');
            if (mainNav.classList.contains('mobile-open')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    }
    
    // Smooth scroll for navigation links
    navItems.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    // Calcular offset considerando el header
                    const headerHeight = header.offsetHeight;
                    const targetPosition = target.offsetTop - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
                
                // Close mobile menu if open
                if (mainNav && mainNav.classList.contains('mobile-open')) {
                    mainNav.classList.remove('mobile-open');
                    const spans = mobileMenuBtn.querySelectorAll('span');
                    spans[0].style.transform = 'none';
                    spans[1].style.opacity = '1';
                    spans[2].style.transform = 'none';
                }
            }
        });
    });
    
    // Update active nav item based on scroll position
    window.addEventListener('scroll', updateActiveNavItem, { passive: true });
}

function updateActiveNavItem() {
    const sections = document.querySelectorAll('section[id], main > section');
    const navItems = document.querySelectorAll('.nav-item');
    
    let currentSection = '';
    const scrollPosition = window.scrollY + 100;
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.offsetHeight;
        
        if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
            currentSection = section.id || section.className.split(' ')[0].replace('-section', '');
        }
    });
    
    navItems.forEach(item => {
        item.classList.remove('active');
        const link = item.querySelector('a');
        const href = link.getAttribute('href').substring(1);
        
        if (href === currentSection || (currentSection === '' && href === 'inicio')) {
            item.classList.add('active');
        }
    });
}

function initializeFooter() {
    // Add any footer-specific JavaScript here
    const socialLinks = document.querySelectorAll('.social-link-figma');
    
    // Remove the preventDefault to allow normal link behavior
    socialLinks.forEach(link => {
        // Add hover effects if needed, but don't prevent default behavior
        link.addEventListener('mouseenter', function() {
            // Optional: Add any hover effects
        });
        
        // Ensure links work properly
        link.addEventListener('click', function(e) {
            // Don't prevent default - let the links work normally
            const href = this.getAttribute('href');
            if (href && href !== '#') {
                // Link will work normally, no need to prevent default
                console.log('Social link clicked:', href);
            } else {
                e.preventDefault();
                console.log('Social link has no valid href');
            }
        });
    });
    
    // Footer contact links - Figma version
    const contactItems = document.querySelectorAll('.contact-item-figma');
    contactItems.forEach(item => {
        const text = item.querySelector('.contact-text-figma').textContent;
        
        // Make email clickable
        if (text.includes('@')) {
            item.style.cursor = 'pointer';
            item.addEventListener('click', function() {
                window.location.href = `mailto:${text}`;
            });
        }
        
        // Make phone clickable
        if (text.includes('+')) {
            item.style.cursor = 'pointer';
            item.addEventListener('click', function() {
                window.location.href = `tel:${text}`;
            });
        }
    });
    
    // Navigation links - Figma version
    const navLinks = document.querySelectorAll('.nav-link-figma');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

function createFallbackHeader() {
    const header = document.getElementById('header');
    header.innerHTML = `
        <div class="header-container">
            <div class="logo">
                <img src="assets/icons/7f131e3ebf5d584ec2316a2e8cf8d25184bccec0.svg" alt="PowerGYMA Logo">
            </div>
            <nav class="main-nav">
                <ul class="nav-menu">
                    <li class="nav-item active"><a href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a href="#servicios">Servicios</a></li>
                    <li class="nav-item"><a href="#nosotros">Nosotros</a></li>
                    <li class="nav-item"><a href="#clientes">Clientes</a></li>
                    <li class="nav-item"><a href="#contacto">Contacto</a></li>
                </ul>
            </nav>
            <div class="header-cta">
                <a href="/login" class="btn btn-access">Acceso Clientes</a>
            </div>
            <button class="mobile-menu-btn" aria-label="Menú móvil">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    `;
    
    // Initialize header functionality after creating fallback
    initializeHeader();
}

function createFallbackFooter() {
    const footer = document.getElementById('footer');
    footer.innerHTML = `
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section company-info">
                    <div class="footer-logo">
                        <img src="assets/icons/fddb5d397fc1b493d667324b77c08f7c1bb3402c.svg" alt="PowerGYMA Logo">
                    </div>
                    <p>Soluciones energéticas innovadoras para empresas que buscan optimización y ahorro.</p>
                </div>
                <div class="footer-section navigation">
                    <h3>Navegación</h3>
                    <ul>
                        <li><a href="#inicio">Inicio</a></li>
                        <li><a href="#servicios">Servicios</a></li>
                        <li><a href="#nosotros">Nosotros</a></li>
                        <li><a href="#clientes">Clientes</a></li>
                        <li><a href="#contacto">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-section contact-info">
                    <h3>Contacto</h3>
                    <div class="contact-item">
                        <span>Calle Energía 123, Madrid</span>
                    </div>
                    <div class="contact-item">
                        <span>+34 911 234 567</span>
                    </div>
                    <div class="contact-item">
                        <span>info@powergyma.com</span>
                    </div>
                </div>
                <div class="footer-section social-media">
                    <h3>Redes Sociales</h3>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook"></a>
                        <a href="#" class="social-link" aria-label="Twitter"></a>
                        <a href="#" class="social-link" aria-label="LinkedIn"></a>
                    </div>
                </div>
            </div>
            <div class="footer-divider"></div>
            <div class="footer-bottom">
                <p>&copy; 2025 POWERGYMA. Todos los derechos reservados.</p>
            </div>
        </div>
    `;
}
