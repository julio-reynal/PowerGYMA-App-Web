<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POWERGYMA - Optimiza tu energía. Controla tu costo</title>
    
    <!-- Vite Assets -->
    @vite(['resources/css/main.css', 'resources/css/components.css', 'resources/js/components.js', 'resources/js/main.js'])
    
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
                                        <span>Ver Nuestros Servicios</span>
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
                                <a href="#" class="service-link">
                                    Ver más
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
                    <a href="{{ route('demo.solicitar') }}" class="btn btn-primary">Solicita una demostración gratuita</a>
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
                        <img src="assets/images/1167e5ab573a0aed46d40b9ad8d07420f4122c19.png" alt="Cliente 1">
                    </div>
                    <div class="client-logo">
                        <img src="assets/images/82245791d1f81b73a5ef2e72d04fb8dbc096bf7b.png" alt="Cliente 2">
                    </div>
                    <div class="client-logo">
                        <img src="assets/images/41952dd1b2184015d5e373c183df547c84d82974.png" alt="Cliente 3">
                    </div>
                    <div class="client-logo">
                        <img src="assets/images/07b977f2a677574603c400e745fc912eff822370.png" alt="Cliente 4">
                    </div>
                    <div class="client-logo">
                        <img src="assets/images/c529db82fbcf4c08836620d07f143e9c44a8179f.png" alt="Cliente 5">
                    </div>
                </div>
                
                <div class="testimonial">
                    <div class="testimonial-content">
                        <div class="quote-mark">"</div>
                        <p>Gracias a POWERGYMA redujimos nuestros costos de energía en un 32% el primer año. Su sistema de predicción nos permite planificar nuestra producción de manera mucho más eficiente.</p>
                        <cite>- Gerente de Operaciones, Empresa XYZ</cite>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact-section-figma">
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
                            <form class="contact-form-figma">
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
                                <div class="checkbox-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="privacyPolicy" required>
                                        <span class="checkbox-custom"></span>
                                        He leído y acepto la política de privacidad y el tratamiento de mis datos
                                    </label>
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
                                <img src="assets/images/87db99a37235bc3657fd7a1d428fb23fe43e13a4.png" alt="Mapa de ubicación" class="map-image">
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
                                            <p class="contact-detail-text">+34 900 123 456</p>
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
                                            <p class="contact-detail-text">Calle Energía, 123<br>28001 Madrid, España</p>
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
                                    <div class="social-icon-f">
                                        <img src="assets/icons/1c82bff56120f7a8612dd55bfe910c82f150186e.svg" alt="Facebook">
                                    </div>
                                    <div class="social-icon-f">
                                        <img src="assets/icons/398f94a44dede11c1af4e3999bf259680207bc74.svg" alt="Twitter">
                                    </div>
                                    <div class="social-icon-f">
                                        <img src="assets/icons/a0ab1de4c5e1466b7919a577eb8162580d2d4c1e.svg" alt="LinkedIn">
                                    </div>
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
</body>
</html>
