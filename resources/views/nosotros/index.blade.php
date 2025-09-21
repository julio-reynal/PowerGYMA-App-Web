<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - POWERGYMA | Somos tu aliado estratégico en energía</title>
    
    {{-- Favicon y PWA meta tags --}}
    @include('components.favicon')
    
    <!-- Vite Assets -->
    @vite(['resources/css/main.css', 'resources/css/components.css', 'resources/css/nosotros.css', 'resources/js/components.js', 'resources/js/main.js'])
    
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
    <main class="nosotros-main">
        <!-- Hero Section -->
        <section class="nosotros-hero-section">
            <div class="nosotros-hero-container">
                <!-- Background with image and gradients -->
                <div class="nosotros-hero-background">
                    <div class="nosotros-hero-bg-image" style="background-image: url('{{ asset('Img/d59ee7973d60e759cd7c99ad2637afa915d0bfe8.png') }}');"></div>
                    <div class="nosotros-hero-gradient-overlay"></div>
                </div>
                
                <!-- Decorative elements -->
                <div class="nosotros-hero-decorative">
                    <div class="decorative-line decorative-line-1"></div>
                    <div class="decorative-line decorative-line-2"></div>
                    <div class="decorative-line decorative-line-3"></div>
                    <div class="decorative-line decorative-line-4"></div>
                    <div class="decorative-line decorative-line-5"></div>
                </div>
                
                <!-- Content -->
                <div class="nosotros-hero-content">
                    <div class="nosotros-hero-content-inner">
                        <h1 class="nosotros-hero-title">Somos tu aliado estratégico en energía</h1>
                        <p class="nosotros-hero-description">Energía inteligente, decisiones estratégicas</p>
                        <a href="{{ route('demo.solicitar') }}" class="nosotros-hero-btn">Conoce más</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="nosotros-about-section">
            <div class="nosotros-about-container">
                <div class="nosotros-about-card">
                    <!-- Background effects -->
                    <div class="nosotros-about-effects">
                        <div class="about-blur-effect blur-orange"></div>
                        <div class="about-blur-effect blur-blue"></div>
                    </div>
                    
                    <div class="nosotros-about-content">
                        <div class="nosotros-about-text">
                            <h2 class="nosotros-about-title">Quiénes Somos</h2>
                            <p class="nosotros-about-description">
                                Nos especializamos en soluciones que permiten a las organizaciones mejorar su eficiencia energética, optimizando sus procesos, que agreguen valor, reduzcan costos y fortalezcan su desempeño en el largo plazo apoyados en las tecnologías de información para el análisis de datos.
                            </p>
                            <div class="nosotros-about-features">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <img src="{{ asset('Img/100342d8087eec55d050bf563638c36887b386a5.svg') }}" alt="Análisis de Datos">
                                    </div>
                                    <span class="feature-label">Análisis de Datos</span>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <img src="{{ asset('Img/a5ddc54df1555ead123a3757ba5f02ed82e694a1.svg') }}" alt="Eficiencia Energética">
                                    </div>
                                    <span class="feature-label">Eficiencia Energética</span>
                                </div>
                            </div>
                        </div>
                        <div class="nosotros-about-image">
                            <img src="{{ asset('Img/5e000563e99ca661005cbb407cf4f754485b5878.png') }}" alt="Nuestro equipo trabajando">
                        </div>
                    </div>
                </div>
                
                <!-- Floating decorative icons -->
                <div class="nosotros-about-decorative-icons">
                    <div class="decorative-icon decorative-icon-1">
                        <img src="{{ asset('Img/ecb12b9859ad18bd57dcb26f82ece97dd7bcc26a.svg') }}" alt="Icono decorativo">
                    </div>
                    <div class="decorative-icon decorative-icon-2">
                        <img src="{{ asset('Img/759a2638106b5cf00daa4f3f1063068d6e4f56af.svg') }}" alt="Icono decorativo">
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission & Vision Section -->
        <section class="nosotros-mission-vision-section">
            <div class="nosotros-mission-vision-container">
                <div class="mission-vision-grid">
                    <div class="mission-card">
                        <div class="mission-vision-icon">
                            <img src="{{ asset('Img/48b44baef915d04b6ce61e8ab8457396c5ad456c.svg') }}" alt="Misión">
                        </div>
                        <h3 class="mission-vision-title">Misión</h3>
                        <p class="mission-vision-text">
                            Diseñar e implementar soluciones de eficiencia energética, peak shaving y consultoría empresarial, que impulsen la productividad y sostenibilidad de nuestros clientes en los sectores industrial, comercial y de servicios.
                        </p>
                    </div>
                    
                    <div class="vision-card">
                        <div class="mission-vision-icon">
                            <img src="{{ asset('Img/32f9d91764c033d8d63ff8068c68e4d1a13e7a88.svg') }}" alt="Visión">
                        </div>
                        <h3 class="mission-vision-title">Visión</h3>
                        <p class="mission-vision-text">
                            Ser reconocidos en Perú y Latinoamérica como una empresa referente en la optimización energética y la transformación estratégica de negocios, generando impacto positivo en la rentabilidad y sostenibilidad de nuestros clientes.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="nosotros-cta-section">
            <div class="nosotros-cta-container">
                <div class="nosotros-cta-content">
                    <h2 class="nosotros-cta-title">¿Listo para optimizar tu consumo energético?</h2>
                    <p class="nosotros-cta-description">Transformamos tus datos en soluciones energéticas inteligentes</p>
                    <a href="{{ route('demo.solicitar') }}" class="nosotros-cta-btn">Solicita una consulta gratuita</a>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="nosotros-values-section">
            <div class="nosotros-values-container">
                <h2 class="nosotros-values-title">Nuestros Valores</h2>
                
                <div class="values-grid">
                    <div class="value-card">
                        <div class="value-icon">
                            <img src="{{ asset('Img/63cf36c0cfc804a522effff2b841b91c460147f6.svg') }}" alt="Innovación">
                        </div>
                        <h3 class="value-title">Innovación</h3>
                        <p class="value-description">Aplicamos tecnologías y enfoques modernos para resolver desafíos complejos.</p>
                    </div>
                    
                    <div class="value-card">
                        <div class="value-icon">
                            <img src="{{ asset('Img/9efee88f7df4e2b2971a76729057db606105f495.svg') }}" alt="Confianza">
                        </div>
                        <h3 class="value-title">Confianza</h3>
                        <p class="value-description">Establecemos relaciones sólidas y transparentes con nuestros clientes.</p>
                    </div>
                    
                    <div class="value-card">
                        <div class="value-icon">
                            <img src="{{ asset('Img/a9c86350f83abaca59d25c12ba133064283e8269.svg') }}" alt="Compromiso">
                        </div>
                        <h3 class="value-title">Compromiso</h3>
                        <p class="value-description">Nos enfocamos en resultados tangibles y sostenibles.</p>
                    </div>
                    
                    <div class="value-card">
                        <div class="value-icon">
                            <img src="{{ asset('Img/ec014410ebfdf722f1eb2f6075694431928c1a1b.svg') }}" alt="Eficiencia">
                        </div>
                        <h3 class="value-title">Eficiencia</h3>
                        <p class="value-description">Optimizamos recursos energéticos y empresariales para generar valor.</p>
                    </div>
                    
                    <div class="value-card">
                        <div class="value-icon">
                            <img src="{{ asset('Img/2e1a78853e72891db97762737ab3ff75a8775c2d.svg') }}" alt="Responsabilidad">
                        </div>
                        <h3 class="value-title">Responsabilidad</h3>
                        <p class="value-description">Promovemos el desarrollo sostenible y el uso consciente de la energía.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="nosotros-team-section">
            <div class="nosotros-team-container">
                <h2 class="nosotros-team-title">Conoce a Nuestro Equipo</h2>
                
                <div class="team-grid">
                    <div class="team-card">
                        <div class="team-photo">
                            <img src="{{ asset('Img/b6beba38f53b2E8f29e855075ab49ad574e2b550f.png') }}" alt="Guido Yauri">
                        </div>
                        <h3 class="team-name">
                            <a href="https://www.linkedin.com/in/guidoyauri/overlay/about-this-profile/" target="_blank" rel="noopener noreferrer">
                                Guido Yauri
                            </a>
                        </h3>
                        <p class="team-position">Directora de Operaciones</p>
                        <div class="team-linkedin">
                            <img src="{{ asset('Img/4ada2df6ebf2999a425dddf81c507001ff883e2d.svg') }}" alt="LinkedIn">
                        </div>
                    </div>
                    
                    <div class="team-card">
                        <div class="team-photo">
                            <img src="{{ asset('Img/0c8b874bf570f1ab539b63133f3e07ca3366fcd.png') }}" alt="Marco Hernandez">
                        </div>
                        <h3 class="team-name">
                            <a href="https://www.linkedin.com/in/marco-hernandez-mendoza-0b156052/overlay/about-this-profile/" target="_blank" rel="noopener noreferrer">
                                Marco Hernandez
                            </a>
                        </h3>
                        <p class="team-position">Director Técnico</p>
                        <div class="team-linkedin">
                            <img src="{{ asset('Img/4ada2df6ebf2999a425dddf81c507001ff883e2d.svg') }}" alt="LinkedIn">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer id="footer">
        @include('components.footer')
    </footer>
</body>
</html>