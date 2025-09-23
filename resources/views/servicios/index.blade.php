@extends('layouts.servicios')

@section('title', 'Servicios')

@push('styles')
@vite(['resources/css/components.css', 'resources/css/servicios.css'])
<style>
/* Inline critical CSS to ensure it loads */
body {
    font-family: 'Poppins', sans-serif !important;
    background: linear-gradient(180deg, #000000 0%, #03081d 100%) !important;
    margin: 0 !important;
    padding: 0 !important;
    min-height: 100vh !important;
}

.servicios-container {
    background: linear-gradient(180deg, #ffffff 10%, #ff010100 0%) !important;
    min-height: 100vh !important;
    padding-top: 90px !important;
}

.hero-section {
    height: 100vh;
    min-height: 700px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #000000;
}

.hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        linear-gradient(45deg, rgba(0, 0, 0, 0.685) 0.64%, rgba(6, 118, 255, 0.575) 1.6%),
        url('{{ asset('Img/91ceeac05d1a7348d95c7409d57b507c61180ecd.png') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0.15;
    z-index: 1;
}
.hero-content {
    position: relative;
    text-align: center;
    color: white;
    z-index: 2;
    max-width: 1024px;
    padding: 0 40px;
}

.hero-title {
    font-size: clamp(32px, 5vw, 60px);
    font-weight: 600;
    line-height: 1.1;
    margin-bottom: 30px;
    color: white;
    font-family: 'Poppins', sans-serif;
}

.hero-subtitle {
    font-size: clamp(16px, 2.5vw, 20px);
    line-height: 1.4;
    color: #d1d5db;
    margin-bottom: 40px;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
    font-family: 'Poppins', sans-serif;
}

.hero-btn {
    background: #db7f13;
    border: none;
    border-radius: 16px;
    padding: 16px 33px;
    color: white;
    font-size: 18px;
    font-weight: 500;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0px 2px 0px 0px rgba(253, 147, 20, 0.3);
    transition: all 0.3s ease;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
}

.hero-btn:hover {
    background: #c46f0f;
    color: white;
    transform: translateY(-2px);
    text-decoration: none;
}
</style>
@endpush

@section('content')
<!-- Header Component -->
@include('components.header')

<div class="servicios-container">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <h1 class="hero-title">Soluciones a la medida de tus necesidades energéticas</h1>
            <p class="hero-subtitle">Optimizamos tu consumo energético con tecnología de vanguardia y experiencia especializada para reducir costos y aumentar eficiencia</p>
            <a href="#servicios" class="hero-btn">Descubre nuestros servicios</a>
        </div>
    </section>

    <!-- Servicios Section -->
    <div id="servicios">
        <!-- Plan SmartPeak -->
        <section class="services-section">
            <div class="section-divider"></div>
            <div class="container-fluid">
                <div class="service-card">
                    <div class="service-image">
                        <div class="service-image-inner">
                            <div class="service-bg" style="background-image: url('{{ asset('Img/3b39f17df9dad116dae9696d40d4f36a95e28c70.png') }}');"></div>
                            <div class="service-overlay smartpeak-overlay"></div>
                        </div>
                    </div>
                    <div class="service-content">
                        <h2 class="service-title">Plan SmartPeak</h2>
                        <h3 class="service-subtitle">La predicción más precisa del mercado en HORA PUNTA</h3>
                        <p class="service-description">
                            Nuestro servicio de predicción utiliza algoritmos avanzados de IA para anticipar los picos de consumo con precisión inigualable. Te permitimos planificar tu consumo energético para evitar las tarifas elevadas durante las horas punta, sin impactar tus operaciones.
                        </p>
                        <div class="benefits-title">Beneficios Clave:</div>
                        <div class="benefits-list">
                            <div class="benefit-item">
                                <div class="benefit-icon orange">
                                    <img src="{{ asset('Img/c100919206cfe1af49861b043bbeaaa62166d45a.svg') }}" alt="" width="14" height="14">
                                </div>
                                <span class="benefit-text">Ahorro garantizado hasta 15%</span>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon orange">
                                    <img src="{{ asset('Img/c100919206cfe1af49861b043bbeaaa62166d45a.svg') }}" alt="" width="14" height="14">
                                </div>
                                <span class="benefit-text">Predicciones con 99.7% de precisión</span>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon orange">
                                    <img src="{{ asset('Img/c100919206cfe1af49861b043bbeaaa62166d45a.svg') }}" alt="" width="14" height="14">
                                </div>
                                <span class="benefit-text">Implementación sin interrupciones operativas</span>
                            </div>
                        </div>
                        <a href="{{ route('demo.solicitar') }}" class="service-btn orange">
                            <img src="{{ asset('Img/959f8dffc25d7eba01c86ab0d94b71de62e0f7ec.svg') }}" alt="" width="16" height="16">
                            Solicita una Demostración Gratuita
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Plan Pico Cero -->
        <section class="services-section gradient">
            <div class="section-divider"></div>
            <div class="container-fluid">
                <div class="service-card">
                    <div class="service-content">
                        <h2 class="service-title">Plan Pico Cero</h2>
                        <h3 class="service-subtitle">Ingeniería de detalle para el consumo de energía</h3>
                        <p class="service-description">
                            Nuestro equipo de ingenieros realiza un análisis exhaustivo de tus líneas de proceso para identificar ineficiencias y diseñar soluciones personalizadas que optimizan el consumo energético sin comprometer la capacidad productiva.
                        </p>
                        <div class="benefits-title">Beneficios Clave:</div>
                        <div class="benefits-list">
                            <div class="benefit-item">
                                <div class="benefit-icon blue">
                                    <img src="{{ asset('Img/6da54caaf086df880acdd370484e8a388d8afab9.svg') }}" alt="" width="14" height="14">
                                </div>
                                <span class="benefit-text">Identificación de ineficiencias ocultas</span>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon blue">
                                    <img src="{{ asset('Img/6da54caaf086df880acdd370484e8a388d8afab9.svg') }}" alt="" width="14" height="14">
                                </div>
                                <span class="benefit-text">Optimización de procesos críticos</span>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon blue">
                                    <img src="{{ asset('Img/6da54caaf086df880acdd370484e8a388d8afab9.svg') }}" alt="" width="14" height="14">
                                </div>
                                <span class="benefit-text">Reducción de hasta 40% en consumos pico</span>
                            </div>
                        </div>
                        <a href="#" class="service-btn blue">
                            <img src="{{ asset('Img/fc26461a05bfcddbbfb7fa52d32907a38e1390b8.svg') }}" alt="" width="16" height="16">
                            Pide una Evaluación Energética
                        </a>
                    </div>
                    <div class="service-image">
                        <div class="service-image-inner">
                            <div class="service-bg" style="background-image: url('{{ asset('Img/1ae16e23b08404e43130cd4d3b9ccc755c63c0c3.png') }}');"></div>
                            <div class="service-overlay picocero-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Plan Smart Tarifa -->
        <section class="services-section">
            <div class="section-divider"></div>
            <div class="container-fluid">
                <div class="service-card">
                    <div class="service-image">
                        <div class="service-image-inner">
                            <div class="service-bg" style="background-image: url('{{ asset('Img/08be88cb7352687c2c2bbfc10d6ac6c883564bd3.png') }}');"></div>
                            <div class="service-overlay smarttarifa-overlay"></div>
                        </div>
                    </div>
                    <div class="service-content">
                        <h2 class="service-title">Plan Smart Tarifa</h2>
                        <h3 class="service-subtitle">Soporte experto para negociar tarifas de energía</h3>
                        <p class="service-description">
                            Nuestro equipo de especialistas en mercado energético te acompaña en la negociación de contratos con proveedores, asegurando las condiciones más favorables y adaptadas a tu perfil de consumo. Maximizamos tu posición como cliente libre en el mercado.
                        </p>
                        <div class="benefits-title">Beneficios Clave:</div>
                        <div class="benefits-list">
                            <div class="benefit-item">
                                <div class="benefit-icon orange square">
                                    <img src="{{ asset('Img/c100919206cfe1af49861b043bbeaaa62166d45a.svg') }}" alt="" width="14" height="14">
                                </div>
                                <span class="benefit-text">Acceso a tarifas hasta 20% inferiores</span>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon orange square">
                                    <img src="{{ asset('Img/c100919206cfe1af49861b043bbeaaa62166d45a.svg') }}" alt="" width="14" height="14">
                                </div>
                                <span class="benefit-text">Negociación experta de contratos</span>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon orange square">
                                    <img src="{{ asset('Img/c100919206cfe1af49861b043bbeaaa62166d45a.svg') }}" alt="" width="14" height="14">
                                </div>
                                <span class="benefit-text">Análisis personalizado del perfil de consumo</span>
                            </div>
                        </div>
                        <a href="#" class="service-btn orange">
                            <img src="{{ asset('Img/cfd3ea55113805f19075a808bf6fe41a7526d203.svg') }}" alt="" width="16" height="16">
                            Consulta a un Experto
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Business Consulting -->
        <section class="services-section gradient">
            <div class="section-divider"></div>
            <div class="container-fluid">
                <div class="service-card">
                    <div class="service-content">
                        <h2 class="service-title">Business Consulting</h2>
                        <h3 class="service-subtitle">Inteligencia Estratégica para Empresas que Buscan Más</h3>
                        <p class="service-description">
                            Transformamos datos en decisiones estratégicas. Nuestra consultoría de negocios va más allá de la energía, integrando análisis de datos, optimización de procesos y transformación digital para impulsar la eficiencia global de tu organización.
                        </p>
                        <div class="benefits-title">Pilares del Servicio:</div>
                        <div class="benefits-list">
                            <div class="benefit-item complex">
                                <div class="benefit-icon blue large">
                                    <img src="{{ asset('Img/0e509837f9e5c3c652c06f220289cea11916141e.svg') }}" alt="" width="20" height="20">
                                </div>
                                <div class="benefit-complex">
                                    <div class="benefit-title">Data Analytics</div>
                                    <div class="benefit-subtitle">Visualización en tiempo real</div>
                                </div>
                            </div>
                            <div class="benefit-item complex">
                                <div class="benefit-icon blue large">
                                    <img src="{{ asset('Img/a3cd86333315ac5a24cc9e87a6ef45d4168b251e.svg') }}" alt="" width="20" height="20">
                                </div>
                                <div class="benefit-complex">
                                    <div class="benefit-title">Business Process Management</div>
                                    <div class="benefit-subtitle">Optimización integral</div>
                                </div>
                            </div>
                            <div class="benefit-item complex">
                                <div class="benefit-icon blue large">
                                    <img src="{{ asset('Img/0845e33047341d1227e962bc9122c24916d791dd.svg') }}" alt="" width="20" height="20">
                                </div>
                                <div class="benefit-complex">
                                    <div class="benefit-title">Transformación Digital</div>
                                    <div class="benefit-subtitle">Estrategias de futuro</div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="service-btn blue">
                            <img src="{{ asset('Img/3866481dc3a8dfbf5a8df1675488fe8e561853f7.svg') }}" alt="" width="16" height="16">
                            Impulsa tu Estrategia
                        </a>
                    </div>
                    <div class="service-image">
                        <div class="service-image-inner">
                            <div class="service-bg" style="background-image: url('{{ asset('Img/a0bc69a4df8d3406ab24b1e63dd085ef16400301.png') }}');"></div>
                            <div class="service-overlay consulting-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Final Divider -->

</div>

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

    <div class="final-divider"></div>
<!-- Footer Component -->
@include('components.footer')

@push('scripts')
@vite(['resources/js/servicios.js'])
@endpush
@endsection