#!/bin/bash
# Script de verificación de entorno para Railway

echo "==================================="
echo "🔍 VERIFICACIÓN DE ENTORNO RAILWAY"
echo "==================================="
echo ""

# Verificar PHP
echo "📦 PHP Version:"
php -v | head -n 1
echo ""

# Verificar Composer
echo "📦 Composer Version:"
composer --version
echo ""

# Verificar variables críticas
echo "🔑 Variables de Entorno Críticas:"
echo "APP_ENV: ${APP_ENV:-NOT SET}"
echo "APP_DEBUG: ${APP_DEBUG:-NOT SET}"
echo "APP_KEY: ${APP_KEY:0:20}... (truncado)"
echo "DB_CONNECTION: ${DB_CONNECTION:-NOT SET}"
echo "DB_HOST: ${DB_HOST:-NOT SET}"
echo ""

# Verificar permisos
echo "📁 Permisos de Storage:"
ls -la storage/ | head -n 5
echo ""

# Verificar archivos críticos
echo "📄 Archivos Críticos:"
[ -f "vendor/autoload.php" ] && echo "✅ vendor/autoload.php" || echo "❌ vendor/autoload.php FALTA"
[ -f "public/build/manifest.json" ] && echo "✅ public/build/manifest.json" || echo "⚠️  public/build/manifest.json FALTA (puede ser normal)"
[ -f ".env" ] && echo "✅ .env" || echo "⚠️  .env FALTA (Railway usa variables)"
echo ""

echo "==================================="
echo "✅ VERIFICACIÓN COMPLETADA"
echo "==================================="
