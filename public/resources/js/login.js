const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

if (togglePassword && password) {
    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // Swap Boxicons classes
        if (this.classList.contains('bx-hide')) {
            this.classList.remove('bx-hide');
            this.classList.add('bx-show');
        } else {
            this.classList.remove('bx-show');
            this.classList.add('bx-hide');
        }
    });
}

// Theme toggle (light/dark using :root class)
const themeToggleBtn = document.getElementById('theme-toggle');
if (themeToggleBtn) {
    const icon = themeToggleBtn.querySelector('i');
    const applyTheme = (theme) => {
        const root = document.documentElement;
        if (theme === 'light') {
            root.classList.add('light');
            icon.classList.remove('bxs-moon');
            icon.classList.add('bxs-sun');
        } else {
            root.classList.remove('light');
            icon.classList.remove('bxs-sun');
            icon.classList.add('bxs-moon');
        }
    };
    const saved = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    applyTheme(saved);
    themeToggleBtn.addEventListener('click', () => {
        const isLight = document.documentElement.classList.contains('light');
        const next = isLight ? 'dark' : 'light';
        localStorage.setItem('theme', next);
        applyTheme(next);
    });
}

// Notifications helper
const container = document.getElementById('notification-container');
if (container) container.setAttribute('aria-live', 'polite'); // accessibility hint

function showNotification(message, type = 'info') {
    if (!container) return;
    const n = document.createElement('div');
    n.className = `notification ${type}`;
    n.setAttribute('role', 'status');
    n.setAttribute('tabindex', '0');

    let icon = '';
    switch (type) {
        case 'error':
            icon = '<i class="bx bx-error-circle"></i>';
            break;
        case 'success':
            icon = '<i class="bx bx-check-circle"></i>';
            break;
        case 'info':
            icon = '<i class="bx bx-info-circle"></i>';
            break;
        default:
            icon = '<i class="bx bx-bell"></i>';
    }

    n.innerHTML = `${icon}<span>${message}</span><button class="close" aria-label="Cerrar notificación">&times;</button>`;
    container.appendChild(n);

    // Timer with pause-on-hover behavior
    const AUTO_CLOSE = 3000; // ms
    let start = Date.now();
    let remaining = AUTO_CLOSE;
    let timeoutId = setTimeout(close, remaining);

    function close() {
        clearTimeout(timeoutId);
        if (!n) return;
        n.classList.add('fade-out');
        setTimeout(() => { if (n && n.parentElement) n.remove(); }, 500);
    }

    const closeBtn = n.querySelector('.close');
    if (closeBtn) closeBtn.addEventListener('click', close);

    // Pause when mouse over or focus (keyboard users)
    n.addEventListener('mouseenter', () => {
        clearTimeout(timeoutId);
        remaining = Math.max(0, AUTO_CLOSE - (Date.now() - start));
    });
    n.addEventListener('mouseleave', () => {
        start = Date.now();
        timeoutId = setTimeout(close, remaining);
    });
    n.addEventListener('focusin', () => {
        clearTimeout(timeoutId);
        remaining = Math.max(0, AUTO_CLOSE - (Date.now() - start));
    });
    n.addEventListener('focusout', () => {
        start = Date.now();
        timeoutId = setTimeout(close, remaining);
    });
}

// Convert server alerts into notifications
document.querySelectorAll('.alert.alert-server').forEach(el => {
    const type = el.dataset.type || 'error';
    const text = el.textContent.trim();
    showNotification(text, type);
    el.remove();
});

// Form validation for login (custom, disable native bubbles)
const form = document.querySelector('form');
if (form) {
    // disable browser's native validation UI
    form.setAttribute('novalidate', 'novalidate');

    const isValidEmail = (value) => {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    };

    // show custom message when browser would show native invalid bubble
    const emailField = document.getElementById('email');
    if (emailField) {
        emailField.addEventListener('invalid', (ev) => {
            ev.preventDefault(); // stop native bubble
            const v = emailField.value.trim();
            if (!v) {
                showNotification('Por favor, ingresa tu correo electrónico.', 'error');
            } else if (!isValidEmail(v)) {
                showNotification('Ingresa un correo válido. Ej: nombre@ejemplo.com', 'error');
            }
            emailField.parentElement.classList.add('error');
        });
    }

    form.addEventListener('submit', function(e) {
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        let hasError = false;

        if (!email) {
            showNotification('Por favor, ingresa tu correo electrónico.', 'error');
            hasError = true;
        } else if (!isValidEmail(email)) {
            showNotification('Ingresa un correo válido. Ej: nombre@ejemplo.com', 'error');
            hasError = true;
        }

        if (!password) {
            showNotification('Por favor, ingresa tu contraseña.', 'error');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            // bring focus to first invalid field
            if (!email || !isValidEmail(email)) {
                document.getElementById('email').focus();
            } else {
                document.getElementById('password').focus();
            }
        } else {
            // Show loading state
            const btn = document.querySelector('.btn-submit');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Iniciando Sesión...';
            }
        }
    });
}

// Real-time validation for subtle feedback
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');

function validateInput(input) {
    const wrapper = input.parentElement;
    if (!input.value.trim()) {
        wrapper.classList.add('error');
    } else {
        wrapper.classList.remove('error');
    }
}

if (emailInput) {
    emailInput.addEventListener('blur', () => validateInput(emailInput));
    emailInput.addEventListener('focus', () => emailInput.parentElement.classList.remove('error'));
    emailInput.addEventListener('input', () => {
        if (emailInput.value.trim()) {
            emailInput.parentElement.classList.remove('error');
        }
    });
}

if (passwordInput) {
    passwordInput.addEventListener('blur', () => validateInput(passwordInput));
    passwordInput.addEventListener('focus', () => passwordInput.parentElement.classList.remove('error'));
    passwordInput.addEventListener('input', () => {
        if (passwordInput.value.trim()) {
            passwordInput.parentElement.classList.remove('error');
        }
    });
}

// mobile header injection removed per user request
