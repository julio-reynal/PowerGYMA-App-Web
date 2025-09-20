// Servicios Page JavaScript - PowerGYMA

document.addEventListener('DOMContentLoaded', function() {
    // Header scroll effect
    function handleHeaderScroll() {
        const header = document.querySelector('header');
        if (!header) return;
        
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }

    // Mobile menu functionality
    function initMobileMenu() {
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const mainNav = document.querySelector('.main-nav');
        
        if (mobileMenuBtn && mainNav) {
            mobileMenuBtn.addEventListener('click', function(e) {
                e.preventDefault();
                mainNav.classList.toggle('mobile-open');
                
                // Animate hamburger menu
                this.classList.toggle('active');
            });
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!mobileMenuBtn.contains(e.target) && !mainNav.contains(e.target)) {
                    mainNav.classList.remove('mobile-open');
                    mobileMenuBtn.classList.remove('active');
                }
            });
            
            // Close mobile menu when clicking on nav links
            const navLinks = mainNav.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mainNav.classList.remove('mobile-open');
                    mobileMenuBtn.classList.remove('active');
                });
            });
        }
    }

    // Smooth scrolling for hero button
    function initSmoothScrolling() {
        const heroBtn = document.querySelector('.hero-btn');
        const serviciosSection = document.querySelector('#servicios');
        
        if (heroBtn && serviciosSection) {
            heroBtn.addEventListener('click', function(e) {
                e.preventDefault();
                serviciosSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        }
    }

    // Intersection Observer for animations
    function initScrollAnimations() {
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

        // First, make service cards animation-ready, then observe them
        const serviceCards = document.querySelectorAll('.service-card');
        serviceCards.forEach(card => {
            card.classList.add('animate-ready');
            observer.observe(card);
        });
    }

    // Performance optimization: throttle scroll events
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }

    // Set active navigation state
    function setActiveNavigation() {
        const navItems = document.querySelectorAll('.nav-item');
        const currentPath = window.location.pathname;
        
        navItems.forEach(item => {
            const link = item.querySelector('a');
            if (link) {
                const href = link.getAttribute('href');
                
                // Check if this is the services page
                if (currentPath.includes('servicios') && href.includes('servicios')) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            }
        });
    }

    // Image lazy loading optimization
    function initLazyLoading() {
        const images = document.querySelectorAll('.service-bg');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.style.opacity = '0.8';
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => imageObserver.observe(img));
        }
    }

    // Service button click handling
    function initServiceButtons() {
        const serviceButtons = document.querySelectorAll('.service-btn');
        
        serviceButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Add loading state
                this.classList.add('loading');
                
                // Simulate action (replace with actual functionality)
                setTimeout(() => {
                    this.classList.remove('loading');
                    // Here you would typically open a modal, redirect, or show a form
                    console.log('Service button clicked:', this.textContent.trim());
                }, 500);
            });
        });
    }

    // Preload critical images
    function preloadImages() {
        const criticalImages = [
            '/Img/91ceeac05d1a7348d95c7409d57b507c61180ecd.png', // Hero background
            '/Img/3b39f17df9dad116dae9696d40d4f36a95e28c70.png', // SmartPeak
            '/Img/1ae16e23b08404e43130cd4d3b9ccc755c63c0c3.png', // Pico Cero
            '/Img/08be88cb7352687c2c2bbfc10d6ac6c883564bd3.png', // Smart Tarifa
            '/Img/a0bc69a4df8d3406ab24b1e63dd085ef16400301.png'  // Business Consulting
        ];

        criticalImages.forEach(src => {
            const img = new Image();
            img.src = src;
        });
    }

    // Initialize all functionality
    function init() {
        // Core functionality
        initMobileMenu();
        initSmoothScrolling();
        setActiveNavigation();
        initServiceButtons();
        
        // Performance optimizations
        preloadImages();
        initLazyLoading();
        
        // Scroll-based functionality
        const throttledScrollHandler = throttle(handleHeaderScroll, 16);
        window.addEventListener('scroll', throttledScrollHandler, { passive: true });
        
        // Animation initialization (only on larger screens for performance)
        if (window.innerWidth > 768) {
            initScrollAnimations();
        }
        
        // Handle resize events
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                // Reinitialize animations on resize if needed
                if (window.innerWidth > 768) {
                    initScrollAnimations();
                }
            }, 250);
        });
    }

    // Initialize everything
    init();
    
    // Run initial header scroll check
    handleHeaderScroll();
});

// Additional CSS for animations (added via JavaScript to avoid render blocking)
const animationStyles = `
.animate-in {
    opacity: 1 !important;
    transform: translateY(0) !important;
}

.service-card {
    opacity: 1 !important;
    transform: translateY(0) !important;
    transition: opacity 0.6s ease, transform 0.6s ease;
}

.service-card.animate-ready {
    opacity: 0;
    transform: translateY(30px);
}

.service-card.animate-ready.animate-in {
    opacity: 1;
    transform: translateY(0);
}

.mobile-menu-btn.active span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.mobile-menu-btn.active span:nth-child(2) {
    opacity: 0;
}

.mobile-menu-btn.active span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -6px);
}

.loading::after {
    content: '';
    display: inline-block;
    width: 12px;
    height: 12px;
    margin-left: 8px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Performance optimizations */
.service-bg,
.service-overlay,
.hero-bg {
    will-change: transform;
    transform: translateZ(0);
}

/* Reduce motion for accessibility */
@media (prefers-reduced-motion: reduce) {
    .service-card {
        transition: none !important;
        opacity: 1 !important;
        transform: none !important;
    }
    
    .animate-in {
        transition: none !important;
    }
    
    @keyframes spin {
        to {
            transform: none;
        }
    }
}
`;

// Inject animation styles
const styleSheet = document.createElement('style');
styleSheet.textContent = animationStyles;
document.head.appendChild(styleSheet);