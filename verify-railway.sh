#!/bin/bash

echo "🔧 Verificando configuración de Railway..."

# Verificar variables de entorno críticas
echo "📋 Variables de entorno:"
echo "APP_URL: $APP_URL"
echo "APP_ENV: $APP_ENV"
echo "APP_DEBUG: $APP_DEBUG"

# Verificar archivos de build
echo "📁 Verificando assets compilados:"
if [ -d "public/build" ]; then
    echo "✅ Directorio public/build existe"
    ls -la public/build/
else
    echo "❌ Directorio public/build NO existe"
fi

# Verificar manifest
if [ -f "public/build/manifest.json" ]; then
    echo "✅ Manifest de Vite existe"
else
    echo "❌ Manifest de Vite NO existe"
fi

# Verificar configuración de Laravel
echo "🔧 Verificando Laravel..."
php artisan config:show app.url
php artisan config:show app.env
php artisan config:show app.debug

# Verificar rutas
echo "📍 Verificando rutas principales:"
php artisan route:list --name=login
php artisan route:list --name=dashboard

echo "✅ Verificación completada"
