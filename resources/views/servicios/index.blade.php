@extends('layouts.servicios')

@section('title', 'Servicios')

@push('styles')
@vite(['resources/css/components.css', 'resources/css/servicios.css', 'resources/css/contacto-figma.css'])
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

    <div class="final-divider"></div>

<!-- Sección de Contacto -->
@include('components.contacto-figma')

<!-- Footer Component -->
@include('components.footer')

@push('scripts')
@vite(['resources/js/servicios.js', 'resources/js/contacto-figma.js'])
@endpush
@endsection