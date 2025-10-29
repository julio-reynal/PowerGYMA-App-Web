#!/bin/bash

echo "🚀 Iniciando PowerGYMA en Railway..."

# Limpiar cachés
echo "🧹 Limpiando cachés..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Ejecutar migraciones
echo "📦 Ejecutando migraciones..."
php artisan migrate --force

# Verificar configuración de correo
echo "📧 Verificando configuración de correo..."
php artisan tinker --execute="
    echo '=== CONFIGURACIÓN DE CORREO ===' . PHP_EOL;
    echo 'MAIL_HOST: ' . config('mail.mailers.smtp.host') . PHP_EOL;
    echo 'MAIL_PORT: ' . config('mail.mailers.smtp.port') . PHP_EOL;
    echo 'MAIL_USERNAME: ' . config('mail.mailers.smtp.username') . PHP_EOL;
    echo 'MAIL_ENCRYPTION: ' . config('mail.mailers.smtp.encryption') . PHP_EOL;
    echo 'MAIL_FROM_ADDRESS: ' . config('mail.from.address') . PHP_EOL;
    echo '=============================' . PHP_EOL;
"

# Iniciar servidor
echo "🌐 Iniciando servidor web en puerto ${PORT:-8080}..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
