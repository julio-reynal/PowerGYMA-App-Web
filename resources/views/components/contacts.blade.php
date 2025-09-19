@extends('layouts.app')

@section('content')
<div class="main-content-panel">
    <div class="background-text-top">
        <h1>¿Listo para transformar tu gestión energética?</h1>
    </div>
    <div class="background-text-bottom">
        <p>Hablemos de cómo POWERGYMA puede diseñar una estrategia a la medida de tus objetivos. El primer paso hacia un futuro más eficiente empieza aquí.</p>
    </div>
    <div class="margin-wrapper">
        <div class="contact-form-container">
            <div class="form-header">
                <h2>Contacta con nosotros</h2>
            </div>
            <div class="form-content">
                <!-- Formulario de Contacto -->
                <div class="contact-form-section">
                    <form id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Nombre <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input type="text" id="name" placeholder="Tu nombre">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input type="email" id="email" placeholder="tucorreo@ejemplo.com">
                                </div>

                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label for="subject">Asunto</label>
                            <div class="input-wrapper">
                                <input type="text" id="subject" placeholder="¿En qué podemos ayudarte?">
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label for="message">Mensaje <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <textarea id="message" placeholder="Detállanos tu consulta y nos pondremos en contacto contigo lo antes posible"></textarea>
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <button type="submit" class="submit-button">Enviar mensaje</button>
                        </div>
                    </form>
                </div>

                <!-- Información de Contacto -->
                <div class="contact-info-section">
                    <div class="map-container">
                        <img src="{{ asset('assets/images/mapa-contacto.png') }}" alt="Mapa de ubicación">
                    </div>
                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="icon-wrapper">
                                <!-- Icono de teléfono -->
                                <img src="{{ asset('assets/icons/telefono.svg') }}" alt="Teléfono" class="contact-icon">
                            </div>
                            <span>+51 946 432 574 / +51 970 894 954</span>
                        </div>
                        <div class="contact-item">
                            <div class="icon-wrapper">
                                <!-- Icono de email -->
                                <img src="{{ asset('assets/icons/email.svg') }}" alt="Email" class="contact-icon">
                            </div>
                            <span>info@powergyma.com</span>
                        </div>
                        <div class="contact-item">
                            <div class="icon-wrapper">
                                <!-- Icono de ubicación -->
                                <img src="{{ asset('assets/icons/ubicacion.svg') }}" alt="Ubicación" class="contact-icon">
                            </div>
                            <span>AV. GAVIOTAS NRO. 1805 LIMA - LIMA - SANTIAGO DE SURCO</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
