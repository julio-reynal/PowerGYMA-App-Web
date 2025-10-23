<!-- Footer Component - Exact Figma Design -->
@push('styles')
@vite(['resources/css/footer.css'])
@endpush

<footer class="footer-figma">
    <div class="footer-container-figma">
        <div class="footer-content-figma">
            <!-- Column 1: Company Info & Logo -->
            <div class="footer-section-company">
                <div class="footer-logo-figma">
                    <img src="{{ asset('Img/a5be701b182eafefc13cf9c7f3794d6ef7f3ac24.svg') }}" alt="PowerGYMA Logo">
                </div>
                <div class="company-description-figma">
                    <p>Soluciones energéticas innovadoras para empresas que buscan optimización y ahorro.</p>
                </div>
            </div>
            
            <!-- Column 2: Navigation -->
            <div class="footer-section-nav">
                <h3 class="footer-title">Navegación</h3>
                <nav class="nav-links-figma">
                    <a href="{{ url('/') }}" class="nav-link-figma">Inicio</a>
                    <a href="{{ url('/servicios') }}" class="nav-link-figma">Servicios</a>
                    <a href="{{ url('/nosotros') }}" class="nav-link-figma">Nosotros</a>
                    <a href="{{ url('/clientes') }}" class="nav-link-figma">Clientes</a>
                    <a href="#contactanos" class="nav-link-figma">Contacto</a>
                </nav>
            </div>
            
            <!-- Column 3: Contact Info -->
            <div class="footer-section-contact">
                <h3 class="footer-title">Contacto</h3>
                <div class="contact-items-figma">
                    <div class="contact-item-figma">
                        <div class="contact-icon-wrapper">
                            <img src="{{ asset('Img/icons/location-icon.svg') }}" alt="Ubicación">
                        </div>
                        <span class="contact-text-figma">Av. Gaviotas Nro. 1805 Lima - Lima - Santiago De Surco</span>
                    </div>
                    <div class="contact-item-figma">
                        <div class="contact-icon-wrapper">
                            <img src="{{ asset('Img/icons/phone-icon.svg') }}" alt="Teléfono">
                        </div>
                        <span class="contact-text-figma">+51 946 432 574 / +51 970 894 954</span>
                    </div>
                    <div class="contact-item-figma">
                        <div class="contact-icon-wrapper">
                            <img src="{{ asset('Img/icons/email-icon.svg') }}" alt="Email">
                        </div>
                        <span class="contact-text-figma">info@powergyma.com</span>
                    </div>
                </div>
            </div>
            
            <!-- Column 4: Social Media -->
            <div class="footer-section-social">
                <h3 class="footer-title">Redes Sociales</h3>
                <div class="social-links-figma">
                    <a href="https://www.linkedin.com/company/power-gyma/" target="_blank" rel="noopener noreferrer" class="social-link-figma" aria-label="LinkedIn">
                        <div class="social-icon-wrapper">
                            <img src="{{ asset('Img/icons/linkedin-icon.svg') }}" alt="LinkedIn">
                        </div>
                    </a>
                    <a href="https://www.instagram.com/powergyma/" target="_blank" rel="noopener noreferrer" class="social-link-figma" aria-label="Instagram">
                        <div class="social-icon-wrapper">
                            <img src="{{ asset('Img/icons/instagram-icon.svg') }}" alt="Instagram">
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Divider Line -->
        <div class="footer-divider-figma">
            <div class="footer-line"></div>
        </div>
        
        <!-- Copyright Section -->
        <div class="footer-bottom-figma">
            <p class="copyright-figma">© 2025 POWERGYMA. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>
