<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POWERGYMA - Optimiza tu energía. Controla tu costo</title>
    
    {{-- Favicon y PWA meta tags --}}
    @include('components.favicon')
    
    <!-- Vite Assets -->
    @vite(['resources/css/main.css', 'resources/css/components.css', 'resources/js/components.js', 'resources/js/main.js', 'resources/js/contact-form.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header Component -->
    <header id="header">
        @include('components.header')
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-main-container">
                <!-- Background with image and gradients -->
                <div class="hero-background" style="background-image: url('assets/images/97f02ab9639ce7dbf4e3a155db14b6f38706498f.png');">
                    <!-- Gradient overlays -->
                    <div class="hero-gradient-overlay"></div>
                    
                    <!-- Blur effects -->
                    <div class="hero-blur-effects">
                        <div class="blur-effect blur-blue-1"></div>
                        <div class="blur-effect blur-orange-1"></div>
                        <div class="blur-effect blur-blue-2"></div>
                        <div class="blur-effect blur-orange-2"></div>
                        <div class="blur-effect blur-blue-3"></div>
                    </div>
                    
                    <!-- Particles -->
                    <div class="hero-particles">
                        <!-- Orange particles -->
                        <div class="particle orange-particle p1"></div>
                        <div class="particle orange-particle p2"></div>
                        <div class="particle orange-particle p3"></div>
                        <div class="particle orange-particle p4"></div>
                        <div class="particle orange-particle p5"></div>
                        
                        <!-- Blue particles -->
                        <div class="particle blue-particle p6"></div>
                        <div class="particle blue-particle p7"></div>
                        <div class="particle blue-particle p8"></div>
                        <div class="particle blue-particle p9"></div>
                        <div class="particle blue-particle p10"></div>
                        
                        <!-- Animated lines -->
                        <div class="particle-line line-orange l1"></div>
                        <div class="particle-line line-blue l2"></div>
                        <div class="particle-line line-blue l3"></div>
                        <div class="particle-line line-orange l4"></div>
                    </div>
                    
                    <!-- Content -->
                    <div class="hero-content">
                        <div class="hero-content-inner">
                            <div class="hero-text-container">
                                <h1 class="hero-title">Optimiza tu energía. Controla tu costo</h1>
                                <p class="hero-description">Soluciones energéticas inteligentes y consultoría estratégica para empresas que buscan reducir costos y maximizar eficiencia.</p>
                                
                                <div class="hero-buttons">
                                    <a href="{{ route('demo.solicitar') }}" class="hero-btn hero-btn-primary">
                                        <span>Solicitar Demo Gratuito</span>
                                    </a>
                                    <button class="hero-btn hero-btn-secondary">
                                        <span onclick="document.querySelector('.services-section').scrollIntoView({behavior:'smooth'});" style="cursor:pointer">Ver Nuestros Servicios</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-section">
            <div class="services-container">
                <h2 class="section-title">Una solución para cada necesidad</h2>
                
                <div class="services-content">
                    <div class="services-menu">
                        <div class="service-item active" data-service="smartpeak">
                            <span>Plan SmartPeak</span>
                        </div>
                        <div class="service-item" data-service="picocero">
                            <span>Plan Pico Cero</span>
                        </div>
                        <div class="service-item" data-service="smarttarifa">
                            <span>Plan Smart Tarifa</span>
                        </div>
                        <div class="service-item" data-service="consulting">
                            <span>Business Consulting</span>
                        </div>
                    </div>
                    
                    <div class="service-showcase">
                        <div class="service-card">
                            <div class="service-image">
                                <img src="assets/images/5ba4c4d57238514056e49d7be097a785436ad1ab.png" alt="Plan SmartPeak">
                            </div>
                            <div class="service-info">
                                <h3>Plan SmartPeak</h3>
                                <p>Optimizamos tus picos de consumo energético para reducir penalizaciones y costes asociados.</p>
                                <a href="{{ url('/servicios#plan-smartpeak') }}" class="service-link">
                                    <span style="cursor:pointer">Ver más</span>
                                    <img src="assets/icons/a6423256919ef67ad6fb02dfe2329e77a12fee54.svg" alt="arrow">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why PowerGYMA Section -->
        <section class="why-section">
            <div class="why-container">
                <h2 class="section-title">¿Por qué <span class="highlight">POWERGYMA?</span></h2>
                
                <div class="benefits-grid">
                    <div class="benefit-card">
                        <div class="benefit-number">01</div>
                        <h3>Ahorro Garantizado</h3>
                        <p>Reducción comprobada de costos energéticos desde el primer mes de implementación.</p>
                    </div>
                    
                    <div class="benefit-card featured">
                        <div class="benefit-number">02</div>
                        <h3>Tecnología de Precisión</h3>
                        <p>Sistemas de medición y predicción con la máxima exactitud del mercado.</p>
                    </div>
                    
                    <div class="benefit-card featured">
                        <div class="benefit-number">03</div>
                        <h3>Asesoría Estratégica</h3>
                        <p>Acompañamiento personalizado por expertos en eficiencia energética industrial.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="cta-container">
                <div class="cta-content">
                    <h2>¿Listo para optimizar tu consumo energético?</h2>
                    <p>Nuestros expertos están listos para ayudarte</p>
                    <a href="#contactanos" class="btn btn-primary">Solicita una demostración gratuita</a>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="process-section">
            <div class="process-container">
                <div class="process-header">
                    <h2>Transformamos datos en ahorro energético</h2>
                    <p>Nuestro enfoque único combina tecnología avanzada con experiencia en el sector energético para ofrecer resultados medibles y significativos.</p>
                </div>
                
                <div class="process-steps">
                    <div class="step">
                        <div class="step-icon">
                            <img src="assets/icons/3f97603a87af24721ee2d8c121a40b9b411a2879.svg" alt="Análisis">
                        </div>
                        <h3>Análisis</h3>
                        <p>Evaluamos tu consumo y identificamos oportunidades</p>
                    </div>
                    
                    <div class="step">
                        <div class="step-icon">
                            <img src="assets/icons/2eb6aaa7fcba4fccc06dfad1965c91df41dc76ca.svg" alt="Estrategia">
                        </div>
                        <h3>Estrategia</h3>
                        <p>Desarrollamos un plan personalizado de optimización</p>
                    </div>
                    
                    <div class="step">
                        <div class="step-icon">
                            <img src="assets/icons/56156ab958a85e76db0717d1ae48bc9d4442b4e2.svg" alt="Implementación">
                        </div>
                        <h3>Implementación</h3>
                        <p>Aplicamos soluciones y medimos resultados</p>
                    </div>
                </div>

                <div class="results-showcase">
                    <div class="results-content">
                        <h3>Resultados comprobados</h3>
                        <p>Nuestros clientes experimentan una reducción promedio del 30% en sus costos energéticos después de implementar nuestras soluciones.</p>
                        
                        <div class="stats">
                            <div class="stat">
                                <span class="stat-number">30%</span>
                                <span class="stat-label">ahorro promedio</span>
                            </div>
                            <div class="stat">
                                <span class="stat-number">200+</span>
                                <span class="stat-label">empresas confían en nosotros</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="results-image">
                        <img src="assets/images/3d2fa5b4d6aa87e932fdff0b2e1a674a518c9b6d.png" alt="Resultados">
                    </div>
                </div>
            </div>
        </section>

        <!-- Clients Section -->
        <section class="clients-section">
            <div class="clients-container">
                <h2>Empresas que confían en nosotros</h2>
                
                <div class="clients-logos">
                    <div class="client-logo">
                        <img src="assets/images/Fisa.svg" alt="Cliente 1">
                    </div>

                </div>
                
                <div class="testimonial">
                    <div class="testimonial-content">
                        <div class="quote-mark">"</div>
                        <p>Gracias a POWERGYMA, reducimos nuestros costos de energía en un 30% en el primer año. Su sistema de predicción nos permite planificar nuestra producción de manera mucho más eficiente.</p>
                        <cite> Elihai, Director</cite>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contactanos" class="contact-section-figma">
            <div class="contact-container">
                <div class="contact-content">
                    <!-- Contact Header -->
                    <div class="contact-header">
                        <div class="contact-badge">
                            <span>Contáctanos</span>
                        </div>
                        <h1 class="contact-title">¿Listo para transformar tu gestión energética?</h1>
                        <p class="contact-subtitle">Hablemos de cómo POWERGYMA puede diseñar una estrategia a la medida de tus objetivos. El primer paso hacia un futuro más eficiente empieza aquí.</p>
                    </div>
                    
                    <!-- Main Content Grid -->
                    <div class="contact-main-grid">
                        <!-- Contact Form Container -->
                        <div class="contact-form-container">
                            <form class="contact-form-figma" id="contactForm">
                                @csrf
                                <!-- First Row -->
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>
                                            <img src="assets/icons/165f92fcd0a7cd05d67278e28a9b9f703b245b84.svg" alt="user">
                                            Nombre completo
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="text" placeholder="Tu nombre y apellidos" name="fullName" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <img src="assets/icons/6e90d1375acabd6e696db24dc9f3754aabd5e7eb.svg" alt="company">
                                            Nombre de la Empresa
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="text" placeholder="Nombre de tu empresa" name="companyName" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Second Row -->
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>
                                            <img src="assets/icons/a15e2de8f4a6a51c4059c293374e092d0fcf384e.svg" alt="email">
                                            Correo Electrónico
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="email" placeholder="ejemplo@empresa.com" name="email" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <img src="assets/icons/3b1908e4ca3063f5f1bac73863f5e4441fdb1bf7.svg" alt="phone">
                                            Teléfono
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="tel" placeholder="+34 600 000 000" name="phone" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Third Row -->
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>
                                            <img src="assets/icons/6e90d1375acabd6e696db24dc9f3754aabd5e7eb.svg" alt="industry">
                                            Sector Industrial
                                        </label>
                                        <div class="select-wrapper">
                                            <select name="industry" required>
                                                <option value="">empresa</option>
                                                <option value="manufacturera">Manufacturera</option>
                                                <option value="alimentaria">Alimentaria</option>
                                                <option value="quimica">Química</option>
                                                <option value="textil">Textil</option>
                                                <option value="automocion">Automoción</option>
                                                <option value="construccion">Construcción</option>
                                                <option value="energia">Energía</option>
                                                <option value="otros">Otros</option>
                                            </select>
                                            <img src="assets/icons/fcd593075edbfd7b47ef7f3777600b10998212d5.svg" alt="arrow" class="select-arrow">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <img src="assets/icons/1baed7c5c463ef657db5862136dd31ce3f5101a5.svg" alt="budget">
                                            Presupuesto Estimado
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="text" placeholder="9999999999" name="budget">
                                        </div>
                                    </div>
                                </div>

                                <!-- Textarea Group -->
                                <div class="textarea-group">
                                    <label>
                                        <img src="assets/icons/a15e2de8f4a6a51c4059c293374e092d0fcf384e.svg" alt="message">
                                        ¿En qué podemos ayudarte?
                                    </label>
                                    <div class="textarea-wrapper">
                                        <textarea placeholder="Describe brevemente tu proyecto o necesidad..." name="message" rows="4"></textarea>
                                    </div>
                                </div>

                                <!-- Radio Group -->
                                <div class="radio-group">
                                    <div class="radio-label">Tipo de consulta preferida:</div>
                                    <div class="radio-options">
                                        <label class="radio-option">
                                            <input type="radio" name="consultType" value="videocall">
                                            <span class="radio-custom"></span>
                                            <img src="assets/icons/01f3c469e1028b0743bbe547d3191d318bc2bcaa.svg" alt="videocall">
                                            Videollamada
                                        </label>
                                        <label class="radio-option">
                                            <input type="radio" name="consultType" value="presential">
                                            <span class="radio-custom"></span>
                                            <img src="assets/icons/2dec80535915fd2395827d4f24332008ffa94525.svg" alt="visit">
                                            Visita presencial
                                        </label>
                                        <label class="radio-option">
                                            <input type="radio" name="consultType" value="phone">
                                            <span class="radio-custom"></span>
                                            <img src="assets/icons/3b1908e4ca3063f5f1bac73863f5e4441fdb1bf7.svg" alt="phone">
                                            Llamada telefónica
                                        </label>
                                    </div>
                                </div>

                                <!-- Checkbox Group -->
                                <div class="form-field-full-new">
                                    <div class="privacy-notice-wrapper">
                                        <p class="privacy-notice-text">
                                            Si haces clic en "Enviar", aceptas nuestros 
                                            <span class="privacy-link" data-tooltip="terms">Términos de servicio</span> 
                                            y la 
                                            <span class="privacy-link" data-tooltip="privacy">Política de privacidad</span>.
                                        </p>
                                        
                                        {{-- Tooltip de Términos --}}
                                        <div class="privacy-tooltip" id="tooltip-terms">
                                            <div class="tooltip-arrow"></div>
                                            <div class="tooltip-content">
                                                <p><strong>Términos y Condiciones</strong></p>
                                                <p>Al enviar este formulario, aceptas nuestros términos y condiciones. Esto incluye el consentimiento para el procesamiento de tus datos personales conforme a nuestra Política de Privacidad. No compartiremos tu información con terceros sin tu permiso explícito. Si tienes alguna duda, contáctanos en <a href="mailto:info@powergyma.com">info@powergyma.com</a>. Al continuar, confirmas que eres mayor de edad y que la información proporcionada es veraz.</p>
                                            </div>
                                        </div>
                                        
                                        {{-- Tooltip de Privacidad --}}
                                        <div class="privacy-tooltip" id="tooltip-privacy">
                                            <div class="tooltip-arrow"></div>
                                            <div class="tooltip-content">
                                                <p><strong>Política de Privacidad</strong></p>
                                                <p>Al enviar este formulario, aceptas nuestros términos y condiciones. Esto incluye el consentimiento para el procesamiento de tus datos personales conforme a nuestra Política de Privacidad. No compartiremos tu información con terceros sin tu permiso explícito. Si tienes alguna duda, contáctanos en <a href="mailto:info@powergyma.com">info@powergyma.com</a>. Al continuar, confirmas que eres mayor de edad y que la información proporcionada es veraz.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="submit-container">
                                    <button type="submit" class="submit-btn-figma">
                                        Solicitar una Consulta
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Contact Info Sidebar -->
                        <div class="contact-info-sidebar">
                        <!-- Map Container -->
                        <div class="map-container">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d1378.956052933266!2d-76.99582709033639!3d-12.16155331036798!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1s%20AV.%20GAVIOTAS%20NRO.%201805%20DPTO.%20701%20INT.!5e0!3m2!1ses!2spe!4v1758309380370!5m2!1ses!2spe" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                            <!-- Contact Details Section -->
                            <div class="contact-details-section">
                                <h2 class="contact-details-title">Información de contacto</h2>
                                
                                <div class="contact-details-list">
                                    <div class="contact-detail-item">
                                        <div class="contact-icon-container">
                                            <img src="assets/icons/64a712fd2c9ea22db909b60876b8e68608bdaf56.svg" alt="phone">
                                        </div>
                                        <div class="contact-detail-content">
                                            <p class="contact-detail-title">Teléfono</p>
                                            <p class="contact-detail-text">+51 946 432 574 / +51 970 894 954</p>
                                        </div>
                                    </div>

                                    <div class="contact-detail-item">
                                        <div class="contact-icon-container">
                                            <img src="assets/icons/22c50f6a1746dac5e71615d864b78c4fc2dfa597.svg" alt="email">
                                        </div>
                                        <div class="contact-detail-content">
                                            <p class="contact-detail-title">Correo Electrónico</p>
                                            <p class="contact-detail-text">info@powergyma.com</p>
                                        </div>
                                    </div>

                                    <div class="contact-detail-item large">
                                        <div class="contact-icon-container">
                                            <img src="assets/icons/b8076a3af624703032b9ad11661685bca69a1bf0.svg" alt="address">
                                        </div>
                                        <div class="contact-detail-content">
                                            <p class="contact-detail-title">Dirección</p>
                                            <p class="contact-detail-text">AV. GAVIOTAS NRO. 1805<br> LIMA - LIMA - SANTIAGO DE SURCO</p>
                                        </div>
                                    </div>

                                    <div class="contact-detail-item large">
                                        <div class="contact-icon-container">
                                            <img src="assets/icons/a3a52c7d2408c1916625d9895ddab09f141fb5a0.svg" alt="hours">
                                        </div>
                                        <div class="contact-detail-content">
                                            <p class="contact-detail-title">Horario de Atención</p>
                                            <p class="contact-detail-text">Lun - Vie: 9:00 - 18:00<br>Sábados: 10:00 - 14:00</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Social Icons -->
                                <div class="contact-social-iconsaa">
                                    <a href="https://www.facebook.com/people/Power-GYMA/61581443061373/" target="_blank" class="social-icon-f">
                                        <img src="assets/icons/1c82bff56120f7a8612dd55bfe910c82f150186e.svg" alt="Facebook">
                                    </a>
                                    <a href="https://www.linkedin.com/company/power-gyma/about/" target="_blank" class="social-icon-f">
                                        <img src="assets/icons/a0ab1de4c5e1466b7919a577eb8162580d2d4c1e.svg" alt="LinkedIn">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gradient Divider -->
            <div class="contact-gradient-divider"></div>
        </section>
    </main>

    <footer id="footer">
        @include('components.footer')
    </footer>
    
    <script>
        // Script inline para asegurar que el formulario funcione
        console.log('🔍 Inline script ejecutándose...');
        
        // SOLUCIÓN: Evitar múltiples event listeners usando una variable de control
        if (!window.contactFormInitialized) {
            window.contactFormInitialized = true;
            
            window.addEventListener('load', function() {
                const form = document.getElementById('contactForm');
                
                console.log('📋 Formulario encontrado:', form);
                
                // Manejar tooltips de términos y privacidad
                const privacyLinks = document.querySelectorAll('.privacy-link');
                
                privacyLinks.forEach(link => {
                    link.addEventListener('mouseenter', function() {
                        const tooltipType = this.getAttribute('data-tooltip');
                        const tooltip = document.getElementById(`tooltip-${tooltipType}`);
                        
                        if (tooltip) {
                            // Ocultar otros tooltips
                            document.querySelectorAll('.privacy-tooltip').forEach(t => {
                                t.classList.remove('active');
                            });
                            
                            // Mostrar el tooltip correspondiente
                            tooltip.classList.add('active');
                        }
                    });
                    
                    link.addEventListener('mouseleave', function(e) {
                        const tooltipType = this.getAttribute('data-tooltip');
                        const tooltip = document.getElementById(`tooltip-${tooltipType}`);
                        
                        if (tooltip) {
                            // Verificar si el mouse se movió al tooltip
                            const relatedTarget = e.relatedTarget;
                            if (!relatedTarget || !tooltip.contains(relatedTarget)) {
                                setTimeout(() => {
                                    if (!tooltip.matches(':hover')) {
                                        tooltip.classList.remove('active');
                                    }
                                }, 100);
                            }
                        }
                    });
                });
                
                // Mantener tooltip visible cuando el mouse está sobre él
                document.querySelectorAll('.privacy-tooltip').forEach(tooltip => {
                    tooltip.addEventListener('mouseleave', function() {
                        this.classList.remove('active');
                    });
                });
                
                // Cerrar tooltips al hacer clic fuera
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.privacy-link') && !e.target.closest('.privacy-tooltip')) {
                        document.querySelectorAll('.privacy-tooltip').forEach(tooltip => {
                            tooltip.classList.remove('active');
                        });
                    }
                });
                
                if (form) {
                    // IMPORTANTE: Usar handleSubmit nombrada para evitar duplicados
                    const handleSubmit = async function(e) {
                    e.preventDefault();
                    console.log('✅ Evento submit capturado!');
                    
                    // FUNCIÓN HELPER: Remover TODAS las notificaciones previas
                    const removeAllNotifications = () => {
                        const existingNotifications = document.querySelectorAll('.contact-notification');
                        console.log(`🗑️ Removiendo ${existingNotifications.length} notificaciones previas`);
                        existingNotifications.forEach(n => n.remove());
                    };
                    
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.textContent;
                    
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Enviando...';
                    
                    const formData = new FormData(form);
                    
                    // AGREGAR AUTOMÁTICAMENTE EL CAMPO privacyPolicy
                    // Ya que el usuario acepta implícitamente al hacer clic en "Enviar"
                    formData.append('privacyPolicy', '1');
                    
                    console.log('📤 Enviando datos...');
                    for (let [key, value] of formData.entries()) {
                        console.log(key + ': ' + value);
                    }
                    
                    try {
                        // Obtener el token CSRF del meta tag o del formulario
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content 
                                       || document.querySelector('input[name="_token"]')?.value;
                        
                        const response = await fetch('/contacto/enviar', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        });
                        
                        const data = await response.json();
                        console.log('📩 Respuesta:', data);
                        
                        if (response.ok && data.success) {
                            // REMOVER NOTIFICACIONES PREVIAS
                            removeAllNotifications();
                            
                            // Mostrar UNA SOLA notificación verde estilizada
                            const notification = document.createElement('div');
                            notification.className = 'contact-notification';
                            notification.style.cssText = `
                                position: fixed;
                                top: 20px;
                                right: 20px;
                                background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                                color: white;
                                padding: 20px 30px;
                                border-radius: 12px;
                                box-shadow: 0 8px 32px rgba(40, 167, 69, 0.4);
                                z-index: 10000;
                                font-family: 'Poppins', sans-serif;
                                font-size: 16px;
                                font-weight: 500;
                                max-width: 400px;
                                animation: slideIn 0.3s ease-out;
                            `;
                            
                            notification.innerHTML = `
                                <div style="display: flex; align-items: start; gap: 15px;">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="flex-shrink: 0; margin-top: 2px;">
                                        <circle cx="12" cy="12" r="11" stroke="white" stroke-width="2" fill="rgba(255,255,255,0.2)"/>
                                        <path d="M7 12l4 4 6-8" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div>
                                        <div style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">
                                            ¡Gracias por tu consulta!
                                        </div>
                                        <div style="font-size: 14px; line-height: 1.5; opacity: 0.95;">
                                            Nos pondremos en contacto contigo en las próximas 24 horas.
                                        </div>
                                    </div>
                                </div>
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
                            document.body.appendChild(notification);
                            
                            // Remover después de 5 segundos
                            setTimeout(() => {
                                notification.style.animation = 'slideOut 0.3s ease-out';
                                setTimeout(() => notification.remove(), 300);
                            }, 5000);
                            
                            // Limpiar formulario
                            form.reset();
                            
                            // Scroll suave al inicio del formulario
                            form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        } else {
                            // REMOVER NOTIFICACIONES PREVIAS
                            removeAllNotifications();
                            
                            const errorNotification = document.createElement('div');
                            errorNotification.className = 'contact-notification';
                            errorNotification.style.cssText = `
                                position: fixed;
                                top: 20px;
                                right: 20px;
                                background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                                color: white;
                                padding: 20px 30px;
                                border-radius: 12px;
                                box-shadow: 0 8px 32px rgba(220, 53, 69, 0.4);
                                z-index: 10000;
                                font-family: 'Poppins', sans-serif;
                                font-size: 16px;
                                font-weight: 500;
                                max-width: 400px;
                                animation: slideIn 0.3s ease-out;
                            `;
                            
                            let errorMsg = data.message || 'Error al enviar el formulario';
                            if (data.errors) {
                                errorMsg = '<ul style="margin: 10px 0 0 0; padding-left: 20px;">';
                                for (let [field, errors] of Object.entries(data.errors)) {
                                    errorMsg += '<li>' + errors.join(', ') + '</li>';
                                }
                                errorMsg += '</ul>';
                            }
                            
                            errorNotification.innerHTML = `
                                <div style="display: flex; align-items: start; gap: 15px;">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="flex-shrink: 0; margin-top: 2px;">
                                        <circle cx="12" cy="12" r="11" stroke="white" stroke-width="2" fill="rgba(255,255,255,0.2)"/>
                                        <path d="M8 8l8 8M16 8l-8 8" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                                    </svg>
                                    <div>
                                        <div style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">
                                            Error al enviar
                                        </div>
                                        <div style="font-size: 14px; line-height: 1.5; opacity: 0.95;">
                                            ${errorMsg}
                                        </div>
                                    </div>
                                </div>
                            `;
                            
                            document.body.appendChild(errorNotification);
                            
                            setTimeout(() => {
                                errorNotification.style.animation = 'slideOut 0.3s ease-out';
                                setTimeout(() => errorNotification.remove(), 300);
                            }, 7000);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        
                        // REMOVER NOTIFICACIONES PREVIAS
                        removeAllNotifications();
                        
                        const errorNotification = document.createElement('div');
                        errorNotification.className = 'contact-notification';
                        errorNotification.style.cssText = `
                            position: fixed;
                            top: 20px;
                            right: 20px;
                            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                            color: white;
                            padding: 20px 30px;
                            border-radius: 12px;
                            box-shadow: 0 8px 32px rgba(220, 53, 69, 0.4);
                            z-index: 10000;
                            font-family: 'Poppins', sans-serif;
                            font-size: 16px;
                            font-weight: 500;
                            max-width: 400px;
                            animation: slideIn 0.3s ease-out;
                        `;
                        
                        errorNotification.innerHTML = `
                            <div style="display: flex; align-items: start; gap: 15px;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="flex-shrink: 0; margin-top: 2px;">
                                    <circle cx="12" cy="12" r="11" stroke="white" stroke-width="2" fill="rgba(255,255,255,0.2)"/>
                                    <path d="M8 8l8 8M16 8l-8 8" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                                </svg>
                                <div>
                                    <div style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">
                                        Error de conexión
                                    </div>
                                    <div style="font-size: 14px; line-height: 1.5; opacity: 0.95;">
                                        ${error.message}
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        document.body.appendChild(errorNotification);
                        
                        setTimeout(() => {
                            errorNotification.style.animation = 'slideOut 0.3s ease-out';
                            setTimeout(() => errorNotification.remove(), 300);
                        }, 7000);
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                };
                
                // Remover cualquier listener previo antes de agregar uno nuevo
                form.removeEventListener('submit', handleSubmit);
                form.addEventListener('submit', handleSubmit);
                
                console.log('✅ Event listener agregado correctamente');
            } else {
                console.error('❌ Formulario #contactForm NO encontrado');
            }
        });
        } else {
            console.log('⚠️ Script ya inicializado, evitando duplicados');
        }
    </script>
</body>
</html>
