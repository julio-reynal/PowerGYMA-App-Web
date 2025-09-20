@extends('layouts.clientes')

@section('title', 'Casos de Éxito - PowerGYMA')

@push('styles')
    @vite(['resources/css/components.css', 'resources/css/clientes.css'])
@endpush

@section('content')
<!-- Header Component -->
@include('components.header')

<div class="clientes-container">
    <!-- Sección Hero -->
    <section class="hero-section">
        <div class="hero-background">
            <div class="hero-overlay"></div>
            <div class="hero-pattern"></div>
        </div>
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Nuestros Casos de Éxito</h1>
                <p class="hero-description">
                    Descubre cómo hemos transformado la gestión energética de empresas líderes con soluciones innovadoras y resultados medibles
                </p>
            </div>
        </div>
    </section>

    <!-- Sección de Casos de Éxito -->
    <section class="casos-section">
        <div class="casos-grid">
            @foreach($casosExito as $caso)
            <div class="caso-card">
                <div class="caso-header">
                    <div class="caso-info">
                        <span class="caso-sector">{{ $caso['sector'] }}</span>
                        <h3 class="caso-titulo">{{ $caso['titulo'] }}</h3>
                    </div>
                    @if($caso['logo_cliente'])
                    <div class="caso-logo">
                        <img src="{{ asset('Img/' . $caso['logo_cliente']) }}" alt="Logo cliente">
                    </div>
                    @endif
                </div>

                <!-- El Desafío -->
                <div class="caso-bloque desafio-bloque">
                    <div class="bloque-header">
                        <div class="bloque-icon">
                            <img src="{{ asset('Img/971e2994d9beae8af8957afc10fd569fe7553926.svg') }}" alt="Desafío" class="critical">
                        </div>
                        <h4 class="bloque-titulo">El Desafío</h4>
                    </div>
                    <p class="bloque-texto">{{ $caso['desafio'] }}</p>
                </div>

                <!-- La Solución -->
                <div class="caso-bloque solucion-bloque">
                    <div class="solucion-borde"></div>
                    <div class="bloque-header">
                        <div class="bloque-icon">
                            <img src="{{ asset('Img/bfe4745b428cc271205b230a2545a9bb0dc21460.svg') }}" alt="Solución" class="critical">
                        </div>
                        <h4 class="bloque-titulo">La Solución POWERGYMA</h4>
                    </div>
                    <p class="bloque-texto">{{ $caso['solucion'] }}</p>
                </div>

                <!-- Los Resultados -->
                <div class="caso-bloque resultados-bloque">
                    <div class="bloque-header">
                        <div class="bloque-icon">
                            <img src="{{ asset('Img/ee49ee71b0f8cc1a076e2aff38e18b53e671b07a.svg') }}" alt="Resultados" class="critical">
                        </div>
                        <h4 class="bloque-titulo">Los Resultados</h4>
                    </div>
                    
                    <div class="resultados-content">
                        <div class="resultados-info">
                            <p class="resultado-descripcion">{{ $caso['resultado_descripcion'] }}</p>
                            
                            <div class="resultados-metricas">
                                <div class="metrica">
                                    <div class="metrica-valor">{{ $caso['resultado_porcentaje'] }}</div>
                                    <div class="metrica-label">{{ $caso['resultado_texto'] }}</div>
                                </div>
                                <div class="metrica">
                                    <div class="metrica-valor">{{ $caso['resultado_monto'] }}</div>
                                    <div class="metrica-label">{{ $caso['resultado_monto_texto'] }}</div>
                                </div>
                                @if(isset($caso['resultado_extra']))
                                <div class="metrica">
                                    <div class="metrica-valor">{{ $caso['resultado_extra'] }}</div>
                                    <div class="metrica-label">{{ $caso['resultado_extra_texto'] }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="resultado-circular">
                            <div class="circular-progress" data-percentage="{{ str_replace(['%', '-'], '', $caso['resultado_circular']) }}">
                                <div class="circular-bg"></div>
                                <div class="circular-fill"></div>
                                <div class="circular-text">{{ $caso['resultado_circular'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Sección de Resultados Comprobables -->
    <section class="resultados-section">
        <div class="resultados-container">
            <div class="resultados-info">
                <h2 class="resultados-titulo">Resultados comprobables</h2>
                <p class="resultados-descripcion">
                    Nuestros clientes experimentan una clara reducción en sus costos energéticos, con soluciones personalizadas que garantizan resultados medibles y duraderos.
                </p>
                <div class="estadisticas-generales">
                    <div class="estadistica">
                        <div class="estadistica-valor">{{ $estadisticas['ahorro_promedio'] }}</div>
                        <div class="estadistica-label">ahorro promedio</div>
                    </div>
                    <div class="estadistica">
                        <div class="estadistica-valor">{{ $estadisticas['empresas_confian'] }}</div>
                        <div class="estadistica-label">empresas confían en nosotros</div>
                    </div>
                </div>
            </div>
            <div class="resultados-imagen">
                <img src="{{ asset('Img/2c2d2909db7fbe751e87f40fffea033415244ff7.png') }}" alt="Sistema POWERGYMA" class="critical">
            </div>
        </div>
    </section>

    <!-- Sección de Testimonios -->
    <section class="testimonios-section">
        @if(count($testimonios) > 0)
        <div class="testimonio-container">
            <div class="testimonio-quote">"</div>
            <blockquote class="testimonio-texto">
                {{ $testimonios[0]['texto'] }}
            </blockquote>
            <cite class="testimonio-autor">{{ $testimonios[0]['autor'] }}</cite>
            @if($testimonios[0]['logo'])
            <div class="testimonio-logo">
                <img src="{{ asset('Img/' . $testimonios[0]['logo']) }}" alt="{{ $testimonios[0]['empresa'] }}" class="critical">
            </div>
            @endif
        </div>
        @endif
    </section>

    <!-- Sección Call to Action -->
    <section class="cta-section">
        <div class="cta-container">
            <div class="cta-content">
                <h2 class="cta-titulo">¿Quieres ser nuestro próximo caso de éxito?</h2>
                <p class="cta-descripcion">
                    Descubre cómo nuestras soluciones de gestión energética pueden transformar tu empresa y reducir significativamente tus costes operativos.
                </p>
                <a href="#" class="cta-button">
                    Solicitar Consulta Gratuita
                    <img src="{{ asset('Img/c0b5440a65fd21a0aa828a6b90d9b46701d40523.svg') }}" alt="Arrow" class="critical">
                </a>
            </div>
            
            <!-- Beneficios -->
            <div class="beneficios-grid">
                <div class="decoracion-izq">
                    <img src="{{ asset('Img/3dcddb6b0c407a862277f3220f8086548963b7dc.svg') }}" alt="Decoración" class="critical">
                </div>
                <div class="decoracion-der">
                    <img src="{{ asset('Img/ae6b43449b697d0e964c140b331692a7f27027b8.svg') }}" alt="Decoración" class="critical">
                </div>
                
                @foreach($beneficios as $beneficio)
                <div class="beneficio-card">
                    <div class="beneficio-icon">
                        <img src="{{ asset('Img/' . $beneficio['icono']) }}" alt="{{ $beneficio['titulo'] }}" class="critical">
                    </div>
                    <h4 class="beneficio-titulo">{{ $beneficio['titulo'] }}</h4>
                    <p class="beneficio-descripcion">{{ $beneficio['descripcion'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<!-- Footer Component -->
@include('components.footer')

@endsection

@push('scripts')
    @vite(['resources/js/components.js', 'resources/js/clientes.js'])
@endpush