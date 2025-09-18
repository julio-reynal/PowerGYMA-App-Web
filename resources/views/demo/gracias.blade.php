<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, viewport-fit=cover" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">
    <title>Solicitud Recibida - Power GYMA</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
    <!-- Confetti Library -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

    <style>
        :root {
            --primary-color: #2563eb; /* Blue-600 */
            --secondary-color: #f59e0b; /* Amber */
            --success-color: #16a34a; /* Green-600 */
            --bg-light: #f1f5f9;
            --bg-dark: #020617; /* Slate-950 */
            --card-bg-light: rgba(255, 255, 255, 0.75);
            --card-bg-dark: rgba(30, 41, 59, 0.75); /* Slate-800 */
            --text-light: #0f172a;
            --text-dark: #f1f5f9;
            --text-muted-light: #475569;
            --text-muted-dark: #94a3b8;
            --border-light: rgba(226, 232, 240, 0.9);
            --border-dark: rgba(51, 65, 82, 0.9);
        }

        html {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-light);
            transition: background-color 0.5s ease, color 0.5s ease;
            overflow: hidden;
        }

        body.dark {
            background-color: var(--bg-dark);
            color: var(--text-dark);
        }

        * { box-sizing: border-box; }

        /* --- Animated Background --- */
        #background-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* --- Keyframe Animations --- */
        @keyframes card-fade-in {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        
        .animate-in {
            opacity: 0;
            animation: content-fade-in 0.8s ease-out forwards;
        }
        
        @keyframes content-fade-in {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes checkmark-draw { to { stroke-dashoffset: 0; } }
        @keyframes checkmark-circle-fill { to { transform: scale(1); } }
        @keyframes timeline-line-draw { to { height: calc(100% - 40px); } }

        /* --- Main Layout --- */
        .main-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1.5rem;
        }
        
        /* --- Success Card --- */
        .success-card {
            width: 100%;
            max-width: 500px;
            background-color: var(--card-bg-light);
            border: 1px solid var(--border-light);
            border-radius: 1.5rem;
            padding: 2.5rem;
            text-align: center;
            position: relative;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: card-fade-in 1s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }
        
        body.dark .success-card {
            background-color: var(--card-bg-dark);
            border-color: var(--border-dark);
        }

        .logo-container {
            margin-bottom: 1.5rem;
            height: 50px;
        }

        .company-logo {
            height: 100%;
            width: auto;
            /* Invert the white logo to dark for the light theme */
            filter: brightness(0.1) saturate(0);
            transition: filter 0.5s ease;
        }

        body.dark .company-logo {
            /* Revert to original white logo for the dark theme */
            filter: none;
        }

        .theme-toggle {
            position: absolute; top: 1rem; right: 1rem;
            background: transparent; border: none; width: 40px; height: 40px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--text-muted-light); font-size: 1.5rem;
            transition: all 0.3s ease;
        }
        body.dark .theme-toggle { color: var(--text-muted-dark); }
        .theme-toggle:hover { color: var(--primary-color); transform: scale(1.1) rotate(15deg); }

        .success-header { margin-bottom: 2rem; }

        .success-icon { width: 70px; height: 70px; margin: 0 auto 1.5rem; }
        .success-icon .circle {
            fill: var(--success-color); transform-origin: center; transform: scale(0);
            animation: checkmark-circle-fill 0.5s 0.6s ease-out forwards;
        }
        .success-icon .checkmark {
            stroke: white; stroke-width: 5; stroke-linecap: round; stroke-linejoin: round;
            stroke-dasharray: 100; stroke-dashoffset: 100;
            animation: checkmark-draw 0.6s 0.9s ease-out forwards;
        }

        .success-header h1 {
            font-size: 2rem; font-weight: 700;
            color: inherit; margin-bottom: 0.5rem;
        }
        .success-header p {
            color: var(--text-muted-light); 
            font-size: 1rem; max-width: 400px; margin: 0 auto;
        }
        
        body.dark .success-header p {
            color: var(--text-muted-dark);
        }

        /* --- Timeline --- */
        .timeline { position: relative; margin: 2rem 0; text-align: left; }
        .timeline::before {
            content: ''; position: absolute; left: 17px; top: 20px;
            width: 2px; height: 0; background-color: var(--border-light);
            animation: timeline-line-draw 1s 1.5s ease-out forwards;
        }
        body.dark .timeline::before {
            background-color: var(--border-dark);
        }
        .timeline-item { display: flex; gap: 1.25rem; position: relative; margin-bottom: 1.5rem; }
        .timeline-item:last-child { margin-bottom: 0; }
        .timeline-icon {
            width: 36px; height: 36px; border-radius: 50%;
            background-color: var(--bg-light); border: 2px solid var(--border-light);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted-light); font-size: 1.25rem; z-index: 1; flex-shrink: 0;
            transition: all 0.3s ease;
        }
        body.dark .timeline-icon { 
            background-color: var(--bg-dark); 
            border-color: var(--border-dark); 
            color: var(--text-muted-dark); 
        }
        .timeline-item.active .timeline-icon {
            border-color: var(--success-color); color: var(--success-color); background-color: #dcfae9;
        }
        body.dark .timeline-item.active .timeline-icon { 
            background-color: rgba(22, 163, 74, 0.1); 
        }
        .timeline-content h3 { font-size: 1rem; font-weight: 600; margin: 0 0 0.1rem; }
        .timeline-content p { 
            font-size: 0.875rem; color: var(--text-muted-light); margin: 0; 
        }
        body.dark .timeline-content p {
            color: var(--text-muted-dark);
        }
        .timeline-item .number-circle {
            background-color: var(--success-color); color: white;
            font-weight: 600; font-size: 1rem;
        }

        /* --- Actions --- */
        .action-buttons {
            margin-top: 2rem; display: flex;
            flex-direction: column; gap: 0.75rem;
        }
        .btn {
            padding: 0.8rem 1.5rem; border-radius: 0.75rem; font-size: 0.9rem;
            font-weight: 600; cursor: pointer; transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
            text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .btn-primary {
            background-color: var(--primary-color); color: white; border: 1px solid var(--primary-color);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
        }
        .btn-primary:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 7px 20px rgba(37, 99, 235, 0.3); 
            text-decoration: none;
            color: white;
        }
        .btn-secondary {
            background-color: transparent; border: 1px solid var(--border-light); color: inherit;
        }
        body.dark .btn-secondary { border-color: var(--border-dark); }
        .btn-secondary:hover { 
            border-color: var(--primary-color); 
            color: var(--primary-color); 
            text-decoration: none;
        }

        /* ==================== RESPONSIVE DESIGN ==================== */
        
        /* Mobile First - Base styles for mobile */
        .main-container {
            padding: 1rem;
        }
        
        .success-card {
            padding: 1.5rem;
            border-radius: 1rem;
            max-width: 100%;
            margin: 0 auto;
        }
        
        .success-header h1 {
            font-size: 1.5rem;
            line-height: 1.3;
        }
        
        .success-header p {
            font-size: 0.875rem;
            line-height: 1.5;
        }
        
        .timeline {
            margin: 1.5rem 0;
        }
        
        .timeline-item {
            gap: 1rem;
            margin-bottom: 1.25rem;
        }
        
        .timeline-icon {
            width: 32px;
            height: 32px;
            font-size: 1rem;
        }
        
        .timeline-content h3 {
            font-size: 0.9rem;
        }
        
        .timeline-content p {
            font-size: 0.8rem;
        }
        
        .action-buttons {
            gap: 0.5rem;
        }
        
        .btn {
            padding: 0.75rem 1.25rem;
            font-size: 0.85rem;
        }
        
        .theme-toggle {
            top: 0.75rem;
            right: 0.75rem;
            width: 36px;
            height: 36px;
            font-size: 1.25rem;
        }
        
        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) {
            .main-container {
                padding: 1.5rem;
            }
            
            .success-card {
                padding: 2rem;
                border-radius: 1.25rem;
                max-width: 500px;
            }
            
            .success-header h1 {
                font-size: 1.75rem;
            }
            
            .success-header p {
                font-size: 0.95rem;
            }
            
            .timeline-item {
                gap: 1.25rem;
                margin-bottom: 1.5rem;
            }
            
            .timeline-icon {
                width: 36px;
                height: 36px;
                font-size: 1.25rem;
            }
            
            .timeline-content h3 {
                font-size: 1rem;
            }
            
            .timeline-content p {
                font-size: 0.875rem;
            }
            
            .action-buttons {
                flex-direction: row;
                justify-content: center;
                gap: 0.75rem;
            }
            
            .btn {
                padding: 0.8rem 1.5rem;
                font-size: 0.9rem;
            }
            
            .theme-toggle {
                top: 1rem;
                right: 1rem;
                width: 40px;
                height: 40px;
                font-size: 1.5rem;
            }
        }
        
        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) {
            .main-container {
                padding: 2rem;
            }
            
            .success-card {
                padding: 2.5rem;
                border-radius: 1.5rem;
                max-width: 550px;
            }
            
            .success-header h1 {
                font-size: 2rem;
            }
            
            .success-header p {
                font-size: 1rem;
            }
            
            .timeline {
                margin: 2rem 0;
            }
            
            .logo-container {
                height: 55px;
            }
        }
        
        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) {
            .main-container {
                padding: 2.5rem;
            }
            
            .success-card {
                padding: 3rem;
                max-width: 600px;
            }
            
            .success-header h1 {
                font-size: 2.25rem;
            }
            
            .logo-container {
                height: 60px;
            }
        }
        
        /* Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {
            .success-card {
                max-width: 650px;
                padding: 3.5rem;
            }
        }
        
        /* High density displays */
        @media only screen and (-webkit-min-device-pixel-ratio: 2),
               only screen and (min--moz-device-pixel-ratio: 2),
               only screen and (-o-min-device-pixel-ratio: 2/1),
               only screen and (min-device-pixel-ratio: 2),
               only screen and (min-resolution: 192dpi),
               only screen and (min-resolution: 2dppx) {
            .success-icon {
                width: 80px;
                height: 80px;
            }
        }
        
        /* Landscape orientation adjustments */
        @media screen and (orientation: landscape) and (max-height: 600px) {
            .main-container {
                padding: 1rem;
                align-items: flex-start;
                justify-content: flex-start;
                padding-top: 2rem;
            }
            
            .success-card {
                padding: 1.5rem;
                max-height: calc(100vh - 4rem);
                overflow-y: auto;
            }
            
            .success-icon {
                width: 50px;
                height: 50px;
            }
            
            .success-header h1 {
                font-size: 1.5rem;
                margin-bottom: 0.25rem;
            }
            
            .timeline {
                margin: 1rem 0;
            }
            
            .timeline-item {
                margin-bottom: 1rem;
            }
        }
        
        /* Very small screens (max 375px) */
        @media (max-width: 375px) {
            .main-container {
                padding: 0.75rem;
            }
            
            .success-card {
                padding: 1.25rem;
                border-radius: 0.75rem;
            }
            
            .success-header h1 {
                font-size: 1.25rem;
            }
            
            .success-header p {
                font-size: 0.8rem;
            }
            
            .timeline-icon {
                width: 28px;
                height: 28px;
                font-size: 0.9rem;
            }
            
            .timeline-content h3 {
                font-size: 0.85rem;
            }
            
            .timeline-content p {
                font-size: 0.75rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .btn {
                padding: 0.65rem 1rem;
                font-size: 0.8rem;
            }
            
            .theme-toggle {
                top: 0.5rem;
                right: 0.5rem;
                width: 32px;
                height: 32px;
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <canvas id="background-canvas"></canvas>
    <div class="main-container">
        <div class="success-card">
            
            <button id="theme-toggle" type="button" class="theme-toggle" aria-label="Cambiar tema">
                <i class='bx bxs-moon'></i>
            </button>
            
            <div class="logo-container animate-in" style="animation-delay: 0.2s;">
                <img src="{{ asset('Img/Ico/Ico-Pw.svg') }}" alt="Logo de POWERGYMA" class="company-logo">
            </div>

            <div class="success-header animate-in" style="animation-delay: 0.4s;">
                <svg class="success-icon" viewBox="0 0 52 52">
                    <circle class="circle" cx="26" cy="26" r="25"/>
                    <path class="checkmark" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
                <h1>¡Solicitud Enviada!</h1>
                <p>Gracias por su interés en Power GYMA. Hemos recibido su solicitud de demo y nos pondremos en contacto con usted pronto.</p>
            </div>

            <div class="timeline animate-in" style="animation-delay: 0.6s;">
                <div class="timeline-item active">
                    <div class="timeline-icon number-circle">1</div>
                    <div class="timeline-content">
                        <h3>Revisión</h3>
                        <p>Nuestro equipo revisará su solicitud y sus necesidades específicas</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon"><i class='bx bx-headphone'></i></div>
                    <div class="timeline-content">
                        <h3>Contacto</h3>
                        <p>Un especialista se pondrá en contacto contigo en las próximas 24 horas</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon"><i class='bx bx-calendar-event'></i></div>
                    <div class="timeline-content">
                        <h3>Demo</h3>
                        <p>Programaremos una demostración personalizada para su empresa</p>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons animate-in" style="animation-delay: 0.8s;">
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i>Volver al Inicio
                </a>
                <a href="{{ route('demo.solicitar') }}" class="btn btn-primary">
                    <i class='bx bx-plus-circle'></i>Nueva Solicitud
                </a>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Theme Toggler ---
            const themeToggle = document.getElementById('theme-toggle');
            const themeToggleIcon = themeToggle.querySelector('i');
            const applyTheme = (theme) => {
                if (theme === 'dark') {
                    document.body.classList.add('dark');
                    themeToggleIcon.className = 'bx bxs-sun';
                } else {
                    document.body.classList.remove('dark');
                    themeToggleIcon.className = 'bx bxs-moon';
                }
                // Re-draw background for new theme
                if(window.drawBackground) window.drawBackground();
            };
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const initialTheme = savedTheme || (prefersDark ? 'dark' : 'light');
            applyTheme(initialTheme);
            themeToggle.addEventListener('click', () => {
                const newTheme = document.body.classList.contains('dark') ? 'light' : 'dark';
                localStorage.setItem('theme', newTheme);
                applyTheme(newTheme);
            });

            // --- Confetti Effect ---
            const confettiCanvas = document.createElement('canvas');
            confettiCanvas.style.position = 'fixed';
            confettiCanvas.style.top = '0';
            confettiCanvas.style.left = '0';
            confettiCanvas.style.width = '100vw';
            confettiCanvas.style.height = '100vh';
            confettiCanvas.style.pointerEvents = 'none';
            confettiCanvas.style.zIndex = '1000';
            document.body.appendChild(confettiCanvas);

            const myConfetti = confetti.create(confettiCanvas, {
                resize: true,
                useWorker: true
            });

            const duration = 3 * 1000;
            const animationEnd = Date.now() + duration;
            const colors = ['#2563eb', '#f59e0b', '#ffffff'];

            function randomInRange(min, max) { return Math.random() * (max - min) + min; }

            const frame = () => {
                const timeLeft = animationEnd - Date.now();
                 if (timeLeft <= 0) {
                    // Cleanup canvas after animation
                    setTimeout(() => {
                        if (confettiCanvas.parentNode) {
                            confettiCanvas.parentNode.removeChild(confettiCanvas);
                        }
                    }, 500);
                    return;
                }

                const particleCount = 50 * (timeLeft / duration);
                myConfetti({
                    startVelocity: 30,
                    spread: 360,
                    ticks: 60,
                    zIndex: 1000,
                    particleCount: particleCount,
                    origin: { x: randomInRange(0.1, 0.9), y: Math.random() - 0.2 },
                    colors: colors
                });

                requestAnimationFrame(frame);
            };
            setTimeout(frame, 500); // Start confetti after a short delay

            // --- Animated Background ---
            const canvas = document.getElementById('background-canvas');
            const ctx = canvas.getContext('2d');
            let animationFrameId;
            let particles = [];
            const particleCount = 80;

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.vx = (Math.random() - 0.5) * 0.7;
                    this.vy = (Math.random() - 0.5) * 0.7;
                    this.size = Math.random() * 2 + 1;
                }

                update() {
                    this.x += this.vx;
                    this.y += this.vy;

                    if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
                }

                draw(particleColor) {
                    ctx.fillStyle = particleColor;
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            const resizeCanvas = () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                particles = [];
                for (let i = 0; i < particleCount; i++) {
                    particles.push(new Particle());
                }
            };
            
            const draw = () => {
                const isDark = document.body.classList.contains('dark');
                const bgColor = isDark ? 'rgba(2, 6, 23, 1)' : 'rgba(241, 245, 249, 1)';
                const particleColor = isDark ? 'rgba(37, 99, 235, 0.8)' : 'rgba(100, 116, 139, 0.6)';
                const lineColor = isDark ? 'rgba(37, 99, 235, 0.15)' : 'rgba(100, 116, 139, 0.15)';
                
                ctx.fillStyle = bgColor;
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                particles.forEach(p1 => {
                    p1.update();
                    p1.draw(particleColor);

                    particles.forEach(p2 => {
                        if (p1 === p2) return;
                        const distance = Math.hypot(p1.x - p2.x, p1.y - p2.y);

                        if (distance < 150) {
                            ctx.strokeStyle = lineColor;
                            ctx.lineWidth = 1;
                            ctx.globalAlpha = 1 - (distance / 150);
                            ctx.beginPath();
                            ctx.moveTo(p1.x, p1.y);
                            ctx.lineTo(p2.x, p2.y);
                            ctx.stroke();
                            ctx.globalAlpha = 1;
                        }
                    });
                });
                
                animationFrameId = requestAnimationFrame(draw);
            };

            const startAnimation = () => {
                if (animationFrameId) {
                    cancelAnimationFrame(animationFrameId);
                }
                resizeCanvas();
                draw();
            };
            
            window.addEventListener('resize', startAnimation);
            
            // Initial call to start everything
            startAnimation();
            window.drawBackground = startAnimation; // Make it globally available for theme changer
        });
    </script>
</body>
</html>