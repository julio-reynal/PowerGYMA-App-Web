@extends('layouts.app')

@section('title', 'Nosotros - PowerGYMA')

@php
    $imageVersion = '?v=' . time(); // Cache buster para forzar recarga de imágenes
@endphp

@push('styles')
<link rel="stylesheet" href="{{ asset('css/nosotros.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    body {
        background-color: #121212 !important;
        margin: 0 !important;
        padding: 0 !important;
        font-family: 'Inter', sans-serif !important;
        overflow-x: hidden;
    }
    
    .main-content {
        padding: 0 !important;
        margin: 0 !important;
        background-color: #121212 !important;
    }
    
    .nosotros-container {
        background-color: #121212;
        min-height: 100vh;
        width: 100%;
        position: relative;
        padding-top: 0;
        margin-top: 0; /* Sin navbar, no necesitamos compensar */
    }
    
    /* Asegurar que las imágenes se muestren correctamente */
    .nosotros-container img {
        display: block;
        max-width: 100%;
        height: auto;
    }
    
    /* Ocultar el navbar en la página de Nosotros */
    nav.navbar {
        display: none !important;
    }
    
    /* Remover el margin negativo ya que no hay navbar */
    .nosotros-container {
        margin-top: 0 !important;
    }
    
    @media (max-width: 768px) {
        .hero-content {
            padding: 0 20px;
        }
        
        .hero-title {
            font-size: 36px !important;
            line-height: 40px !important;
        }
        
        .hero-subtitle {
            font-size: 18px !important;
        }
        
        .section-padding {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }
        
        .grid-valores {
            grid-template-columns: 1fr !important;
        }
        
        .grid-mision-vision {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@section('content')
<div class="nosotros-container">
    <!-- Hero Section -->
    <section style="position: relative; height: 600px; width: 100%; padding-top: 0; background-color: #121212;">
        <!-- Background Image with Overlay -->
        <div style="position: absolute; inset: 0; overflow: hidden;">
            <div style="position: absolute; height: 600px; left: 0; top: 0; width: 100%; background: linear-gradient(180deg, rgba(10,10,10,0) 0%, rgba(18,18,18,0) 100%);">
                <div style="position: absolute; height: 600px; left: 0; top: 0; width: 100%; opacity: 0.2; z-index: 1;">
                    <img src="{{ asset('assets/images/nosotros/d59ee7973d60e759cd7c99ad2637afa915d0bfe8.png') }}{{ $imageVersion }}" 
                         alt="Hero Background" 
                         onerror="console.error('Failed to load hero image:', this.src); this.style.display='none';"
                         onload="console.log('Hero image loaded successfully');"
                         style="position: absolute; left: 0; top: 0; width: 100%; height: 100%; object-fit: cover; object-position: center center; display: block;">
                </div>
            </div>
        </div>
        
        <!-- Decorative Lines -->
        <div style="position: absolute; height: 80px; left: 0; opacity: 0.3; top: 520px; width: 100%; z-index: 2;">
            <div style="position: absolute; background: #fa8c16; height: 64px; left: 25%; top: 16px; width: 2px;"></div>
            <div style="position: absolute; background: #1a3a6c; height: 96px; left: 33.33%; top: -16px; width: 1px;"></div>
            <div style="position: absolute; background: #fa8c16; height: 80px; left: 50%; top: 0; width: 3px;"></div>
            <div style="position: absolute; background: #1a3a6c; height: 128px; left: 66.66%; top: -48px; width: 1px;"></div>
            <div style="position: absolute; background: #fa8c16; height: 48px; left: 75%; top: 32px; width: 2px;"></div>
        </div>
        
        <!-- Hero Content -->
        <div class="hero-content" style="position: absolute; height: 256px; left: 50%; top: 50%; transform: translate(-50%, -50%); width: 100%; max-width: 896px; padding: 0 16px; z-index: 10;">
            <div style="position: relative; height: 120px; text-align: center; margin-bottom: 24px;">
                <h1 class="hero-title" style="font-family: 'Inter', sans-serif; font-weight: 800; font-size: 60px; line-height: 60px; text-align: center; color: white; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                    Somos tu aliado estratégico en energía
                </h1>
            </div>
            <div style="text-align: center; margin-bottom: 32px;">
                <p class="hero-subtitle" style="font-family: 'Inter', sans-serif; font-weight: 400; font-size: 24px; line-height: 32px; text-align: center; color: #e0e0e0; margin: 0; text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
                    Energía inteligente, decisiones estratégicas
                </p>
            </div>
            <div style="text-align: center;">
                <a href="#contacto" style="display: inline-block; background: #fa8c16; color: white; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-family: 'Inter', sans-serif; font-size: 16px; line-height: 24px; transition: all 0.3s; box-shadow: 0 2px 8px rgba(250, 140, 22, 0.3);">
                    Conoce más
                </a>
            </div>
        </div>
    </section>

    <!-- Quiénes Somos Section -->
    <section style="position: relative; padding: 80px 0;">
        <div class="section-padding" style="max-width: 1920px; margin: 0 auto; padding: 0 320px;">
            <div style="background: #152846; border: 1px solid rgba(26, 58, 108, 0.3); border-radius: 8px; position: relative; overflow: hidden;">
                <!-- Decorative Background Effects -->
                <div style="position: absolute; height: 416px; right: 0; opacity: 0.1; top: 1px; width: 426px; pointer-events: none;">
                    <div style="position: absolute; background: rgba(250, 140, 22, 0.2); filter: blur(96px); left: 159.5px; border-radius: 9999px; width: 160px; height: 160px; top: 104px;"></div>
                    <div style="position: absolute; background: rgba(26, 58, 108, 0.3); filter: blur(96px); left: 44px; border-radius: 9999px; width: 240px; height: 240px; top: 72px;"></div>
                </div>
                
                <div style="display: flex; gap: 64px; padding: 49px; position: relative; z-index: 10; flex-wrap: wrap;">
                    <!-- Left Content -->
                    <div style="flex: 1; min-width: 300px;">
                        <h2 style="color: #fa8c16; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 36px; line-height: 40px; margin: 0 0 32px 0;">
                            Quiénes Somos
                        </h2>
                        <p style="color: #e0e0e0; font-family: 'Inter', sans-serif; font-size: 18px; line-height: 29.25px; margin: 0 0 32px 0; max-width: 559px;">
                            Nos especializamos en soluciones que permiten a las organizaciones mejorar su eficiencia energética, optimizando sus procesos, que agreguen valor, reduzcan costos y fortalezcan su desempeño en el largo plazo apoyados en las tecnologías de información para el análisis de datos.
                        </p>
                        
                        <!-- Features -->
                        <div style="display: flex; gap: 32px; flex-wrap: wrap;">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                <div style="width: 48px; height: 48px;">
                                    <img src="{{ asset('assets/images/nosotros/ecc850cd1dd65210bc095a061bebc08fd56bd05e.svg') }}{{ $imageVersion }}" 
                                         alt="Análisis de Datos" 
                                         onerror="console.error('Failed to load icon:', this.src);"
                                         style="display: block; width: 100%; height: 100%;">
                                </div>
                                <span style="color: white; font-family: 'Inter', sans-serif; font-weight: 500; font-size: 16px; line-height: 24px; text-align: center;">
                                    Análisis de Datos
                                </span>
                            </div>
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                <div style="width: 48px; height: 48px;">
                                    <img src="{{ asset('assets/images/nosotros/a806b20c6145735ac6240cd2839f89e18c6cb6fa.svg') }}{{ $imageVersion }}" 
                                         alt="Eficiencia Energética" 
                                         onerror="console.error('Failed to load icon:', this.src);"
                                         style="display: block; width: 100%; height: 100%;">
                                </div>
                                <span style="color: white; font-family: 'Inter', sans-serif; font-weight: 500; font-size: 16px; line-height: 24px; text-align: center;">
                                    Eficiencia Energética
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Image -->
                    <div style="flex: 1; display: flex; align-items: center; justify-content: center; min-width: 300px;">
                        <div style="width: 100%; max-width: 559px; height: 320px; overflow: hidden; border-radius: 8px;">
                            <img src="{{ asset('assets/images/nosotros/5e000563e99ca661005cbb407cf4f754485b5878.png') }}{{ $imageVersion }}" 
                                 alt="Equipo de trabajo" 
                                 onerror="console.error('Failed to load team image:', this.src);"
                                 onload="console.log('Team image loaded');"
                                 style="display: block; width: 100%; height: 100%; object-fit: cover; object-position: center center;">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Decorative Icons -->
            <div style="position: absolute; right: 20%; top: 36px; background: white; border-radius: 8px; box-shadow: 0px 10px 15px -3px rgba(0,0,0,0.1), 0px 4px 6px -4px rgba(0,0,0,0.1); width: 88px; height: 88px; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('assets/images/nosotros/ecb12b9859ad18bd57dcb26f82ece97dd7bcc26a.svg') }}{{ $imageVersion }}" 
                     alt="Icon" 
                     onerror="console.error('Failed to load decorative icon:', this.src);"
                     style="width: 48px; height: 48px;">
            </div>
            <div style="position: absolute; left: 15%; bottom: -95px; background: white; border-radius: 8px; box-shadow: 0px 10px 15px -3px rgba(0,0,0,0.1), 0px 4px 6px -4px rgba(0,0,0,0.1); width: 88px; height: 88px; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('assets/images/nosotros/759a2638106b5cf00daa4f3f1063068d6e4f56af.svg') }}{{ $imageVersion }}" 
                     alt="Icon" 
                     onerror="console.error('Failed to load decorative icon:', this.src);"
                     style="width: 48px; height: 48px;">
            </div>
        </div>
    </section>

    <!-- Divider -->
    <div style="max-width: 1152px; margin: 40px auto; padding: 0 20px;">
        <div style="height: 1px; background: linear-gradient(90deg, #1a3a6c 0%, #fa8c16 50%, #1a3a6c 100%);"></div>
    </div>

    <!-- Misión y Visión Section -->
    <section class="section-padding" style="padding: 80px 320px;">
        <div style="max-width: 1280px; margin: 0 auto;">
            <div class="grid-mision-vision" style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
                <!-- Misión Card -->
                <div style="background: #0a0a0a; border: 1px solid rgba(26, 58, 108, 0.3); border-radius: 8px; padding: 33px;">
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                        <div style="padding-bottom: 24px;">
                            <div style="background: rgba(250, 140, 22, 0.1); border-radius: 9999px; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('assets/images/nosotros/48b44baef915d04b6ce61e8ab8457396c5ad456c.svg') }}{{ $imageVersion }}" 
                                     alt="Misión" 
                                     onerror="console.error('Failed to load mission icon:', this.src);"
                                     style="width: 40px; height: 40px;">
                            </div>
                        </div>
                        <div style="padding-bottom: 16px;">
                            <h3 style="color: white; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 30px; line-height: 36px; margin: 0;">
                                Misión
                            </h3>
                        </div>
                        <p style="color: #e0e0e0; font-family: 'Inter', sans-serif; font-size: 16px; line-height: 26px; margin: 0;">
                            Diseñar e implementar soluciones de eficiencia energética, peak shaving y consultoría empresarial, que impulsen la productividad y sostenibilidad de nuestros clientes en los sectores industrial, comercial y de servicios.
                        </p>
                    </div>
                </div>
                
                <!-- Visión Card -->
                <div style="background: #0a0a0a; border: 1px solid rgba(26, 58, 108, 0.3); border-radius: 8px; padding: 33px;">
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                        <div style="padding-bottom: 24px;">
                            <div style="background: rgba(250, 140, 22, 0.1); border-radius: 9999px; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('assets/images/nosotros/32f9d91764c033d8d63ff8068c68e4d1a13e7a88.svg') }}{{ $imageVersion }}" 
                                     alt="Visión" 
                                     onerror="console.error('Failed to load vision icon:', this.src);"
                                     style="width: 40px; height: 40px;">
                            </div>
                        </div>
                        <div style="padding-bottom: 16px;">
                            <h3 style="color: white; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 30px; line-height: 36px; margin: 0;">
                                Visión
                            </h3>
                        </div>
                        <p style="color: #e0e0e0; font-family: 'Inter', sans-serif; font-size: 16px; line-height: 26px; margin: 0;">
                            Ser reconocidos en Perú y Latinoamérica como una empresa referente en la optimización energética y la transformación estratégica de negocios, generando impacto positivo en la rentabilidad y sostenibilidad de nuestros clientes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="background: linear-gradient(90deg, #0a0a0a 0%, rgba(26, 58, 108, 0.7) 100%); padding: 64px 20px;">
        <div style="max-width: 896px; margin: 0 auto; text-align: center;">
            <h2 style="color: white; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 30px; line-height: 36px; margin: 0 0 24px 0;">
                ¿Listo para optimizar tu consumo energético?
            </h2>
            <p style="color: #e0e0e0; font-family: 'Inter', sans-serif; font-size: 18px; line-height: 28px; margin: 0 0 32px 0;">
                Transformamos tus datos en soluciones energéticas inteligentes
            </p>
            <a href="{{ route('contacto') }}" style="display: inline-block; background: #fa8c16; color: white; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-family: 'Inter', sans-serif; font-size: 16px; line-height: 24px; transition: background 0.3s;">
                Solicita una consulta gratuita
            </a>
        </div>
    </section>

    <!-- Nuestros Valores Section -->
    <section style="background: #0a0a0a; padding: 80px 20px;">
        <div style="max-width: 1280px; margin: 0 auto;">
            <h2 style="color: #fa8c16; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 36px; line-height: 40px; text-align: center; margin: 0 0 104px 0;">
                Nuestros Valores
            </h2>
            
            <div class="grid-valores" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 24px;">
                <!-- Innovación -->
                <div style="background: #0a0a0a; border-bottom: 2px solid #fa8c16; border-radius: 8px; padding: 24px;">
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                        <div style="padding-bottom: 16px;">
                            <div style="background: rgba(250, 140, 22, 0.1); border-radius: 9999px; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('assets/images/nosotros/63cf36c0cfc804a522effff2b841b91c460147f6.svg') }}{{ $imageVersion }}" 
                                     alt="Innovación" 
                                     onerror="console.error('Failed to load value icon:', this.src);"
                                     style="width: 32px; height: 32px;">
                            </div>
                        </div>
                        <div style="padding-bottom: 8px;">
                            <h4 style="color: white; font-family: 'Inter', sans-serif; font-weight: 500; font-size: 20px; line-height: 28px; margin: 0;">
                                Innovación
                            </h4>
                        </div>
                        <p style="color: #e0e0e0; font-family: 'Inter', sans-serif; font-size: 14px; line-height: 20px; margin: 0;">
                            Aplicamos tecnologías y enfoques modernos para resolver desafíos complejos.
                        </p>
                    </div>
                </div>
                
                <!-- Confianza -->
                <div style="background: #0a0a0a; border-bottom: 2px solid #fa8c16; border-radius: 8px; padding: 24px;">
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                        <div style="padding-bottom: 16px;">
                            <div style="background: rgba(250, 140, 22, 0.1); border-radius: 9999px; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('assets/images/nosotros/9efee88f7df4e2b2971a76729057db606105f495.svg') }}{{ $imageVersion }}" 
                                     alt="Confianza" 
                                     onerror="console.error('Failed to load value icon:', this.src);"
                                     style="width: 32px; height: 25.6px;">
                            </div>
                        </div>
                        <div style="padding-bottom: 8px;">
                            <h4 style="color: white; font-family: 'Inter', sans-serif; font-weight: 500; font-size: 20px; line-height: 28px; margin: 0;">
                                Confianza
                            </h4>
                        </div>
                        <p style="color: #e0e0e0; font-family: 'Inter', sans-serif; font-size: 14px; line-height: 20px; margin: 0;">
                            Establecemos relaciones sólidas y transparentes con nuestros clientes.
                        </p>
                    </div>
                </div>
                
                <!-- Compromiso -->
                <div style="background: #0a0a0a; border-bottom: 2px solid #fa8c16; border-radius: 8px; padding: 24px;">
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                        <div style="padding-bottom: 16px;">
                            <div style="background: rgba(250, 140, 22, 0.1); border-radius: 9999px; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('assets/images/nosotros/a9c86350f83abaca59d25c12ba133064283e8269.svg') }}{{ $imageVersion }}" 
                                     alt="Compromiso" 
                                     onerror="console.error('Failed to load value icon:', this.src);"
                                     style="width: 32px; height: 32px;">
                            </div>
                        </div>
                        <div style="padding-bottom: 8px;">
                            <h4 style="color: white; font-family: 'Inter', sans-serif; font-weight: 500; font-size: 20px; line-height: 28px; margin: 0;">
                                Compromiso
                            </h4>
                        </div>
                        <p style="color: #e0e0e0; font-family: 'Inter', sans-serif; font-size: 14px; line-height: 20px; margin: 0;">
                            Nos enfocamos en resultados tangibles y sostenibles.
                        </p>
                    </div>
                </div>
                
                <!-- Eficiencia -->
                <div style="background: #0a0a0a; border-bottom: 2px solid #fa8c16; border-radius: 8px; padding: 24px;">
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                        <div style="padding-bottom: 16px;">
                            <div style="background: rgba(250, 140, 22, 0.1); border-radius: 9999px; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('assets/images/nosotros/ec014410ebfdf722f1eb2f6075694431928c1a1b.svg') }}{{ $imageVersion }}" 
                                     alt="Eficiencia" 
                                     onerror="console.error('Failed to load value icon:', this.src);"
                                     style="width: 32px; height: 32px;">
                            </div>
                        </div>
                        <div style="padding-bottom: 8px;">
                            <h4 style="color: white; font-family: 'Inter', sans-serif; font-weight: 500; font-size: 20px; line-height: 28px; margin: 0;">
                                Eficiencia
                            </h4>
                        </div>
                        <p style="color: #e0e0e0; font-family: 'Inter', sans-serif; font-size: 14px; line-height: 20px; margin: 0;">
                            Optimizamos recursos energéticos y empresariales para generar valor.
                        </p>
                    </div>
                </div>
                
                <!-- Responsabilidad -->
                <div style="background: #0a0a0a; border-bottom: 2px solid #fa8c16; border-radius: 8px; padding: 24px;">
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                        <div style="padding-bottom: 16px;">
                            <div style="background: rgba(250, 140, 22, 0.1); border-radius: 9999px; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('assets/images/nosotros/4d62fca146931f6c253e459ba61246566a3c5a06.svg') }}{{ $imageVersion }}" 
                                     alt="Responsabilidad" 
                                     onerror="console.error('Failed to load value icon:', this.src);"
                                     style="width: 32px; height: 28.444px;">
                            </div>
                        </div>
                        <div style="padding-bottom: 8px;">
                            <h4 style="color: white; font-family: 'Inter', sans-serif; font-weight: 500; font-size: 20px; line-height: 28px; margin: 0;">
                                Responsabilidad
                            </h4>
                        </div>
                        <p style="color: #e0e0e0; font-family: 'Inter', sans-serif; font-size: 14px; line-height: 20px; margin: 0;">
                            Promovemos el desarrollo sostenible y el uso consciente de la energía.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Divider -->
    <div style="max-width: 1152px; margin: 40px auto; padding: 0 20px;">
        <div style="height: 1px; background: linear-gradient(90deg, #1a3a6c 0%, #fa8c16 50%, #1a3a6c 100%);"></div>
    </div>

    <!-- Conoce a Nuestro Equipo Section -->
    <section style="background: rgba(0, 0, 0, 0.3); padding: 80px 20px;">
        <div style="max-width: 1280px; margin: 0 auto;">
            <h2 style="color: #fa8c16; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 36px; line-height: 40px; margin: 0 0 88px 0;">
                Conoce a Nuestro Equipo
            </h2>
            
            <div style="display: flex; gap: 32px; justify-content: center; flex-wrap: wrap;">
                <!-- Marco Hernandez -->
                <div style="background: rgba(0, 0, 0, 0.5); border: 1px solid #243b55; border-radius: 8px; padding: 25px; width: 296px;">
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <div style="padding-bottom: 16px;">
                            <div style="border: 2px solid rgba(250, 140, 22, 0.3); border-radius: 50%; width: 128px; height: 128px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #1a1a1a;">
                                <img src="{{ asset('assets/images/nosotros/Perfil-m.jpeg') }}{{ $imageVersion }}" 
                                     alt="Marco Hernandez" 
                                     onerror="console.error('Failed to load profile photo:', this.src);"
                                     onload="console.log('Marco photo loaded');"
                                     style="display: block; width: 100%; height: 100%; object-fit: cover; object-position: center center; border-radius: 50%;">
                            </div>
                        </div>
                        <div style="padding-bottom: 4px;">
                            <a href="https://www.linkedin.com/in/marco-hernandez-mendoza-0b156052/" 
                               target="_blank"
                               style="color: white; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 20px; line-height: 28px; text-decoration: underline;">
                                Marco Hernandez
                            </a>
                        </div>
                        <div style="padding-bottom: 16px;">
                            <p style="color: #fa8c16; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 14px; line-height: 20px; margin: 0;">
                                Gerencia General
                            </p>
                        </div>
                        <a href="https://www.linkedin.com/in/marco-hernandez-mendoza-0b156052/" 
                           target="_blank"
                           style="width: 24px; height: 24px;">
                            <img src="{{ asset('assets/images/nosotros/783d89024f935bb79f8761caf4b8649327e4a44f.svg') }}{{ $imageVersion }}" 
                                 alt="LinkedIn" 
                                 onerror="console.error('Failed to load LinkedIn icon:', this.src);"
                                 style="display: block; width: 100%; height: 100%;">
                        </a>
                    </div>
                </div>
                
                <!-- Guido Yauri -->
                <div style="background: rgba(0, 0, 0, 0.5); border: 1px solid #243b55; border-radius: 8px; padding: 25px; width: 296px;">
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <div style="padding-bottom: 16px;">
                            <div style="border: 2px solid rgba(250, 140, 22, 0.3); border-radius: 50%; width: 128px; height: 128px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #1a1a1a;">
                                <img src="{{ asset('assets/images/nosotros/perfil-g.jpg') }}{{ $imageVersion }}" 
                                     alt="Guido Yauri" 
                                     onerror="console.error('Failed to load profile photo:', this.src);"
                                     onload="console.log('Guido photo loaded');"
                                     style="display: block; width: 100%; height: 100%; object-fit: cover; object-position: center center; border-radius: 50%;">
                            </div>
                        </div>
                        <div style="padding-bottom: 4px;">
                            <a href="https://www.linkedin.com/in/guidoyauri/" 
                               target="_blank"
                               style="color: white; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 20px; line-height: 28px; text-decoration: underline;">
                                Guido Yauri
                            </a>
                        </div>
                        <div style="padding-bottom: 16px;">
                            <p style="color: #fa8c16; font-family: 'Inter', sans-serif; font-weight: 700; font-size: 14px; line-height: 20px; margin: 0;">
                                Directora de Operaciones
                            </p>
                        </div>
                        <a href="https://www.linkedin.com/in/guidoyauri/" 
                           target="_blank"
                           style="width: 24px; height: 24px;">
                            <img src="{{ asset('assets/images/nosotros/57e07a97f18b65e6a60c67084b4d044da4a38167.svg') }}{{ $imageVersion }}" 
                                 alt="LinkedIn" 
                                 onerror="console.error('Failed to load LinkedIn icon:', this.src);"
                                 style="display: block; width: 100%; height: 100%;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Add media query support for responsive grid
if (window.matchMedia('(max-width: 1024px)').matches) {
    document.querySelectorAll('.grid-valores').forEach(el => {
        el.style.gridTemplateColumns = 'repeat(2, 1fr)';
    });
}

if (window.matchMedia('(max-width: 640px)').matches) {
    document.querySelectorAll('.grid-valores').forEach(el => {
        el.style.gridTemplateColumns = '1fr';
    });
    document.querySelectorAll('.grid-mision-vision').forEach(el => {
        el.style.gridTemplateColumns = '1fr';
    });
}
</script>
@endsection
