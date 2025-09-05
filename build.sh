#!/bin/bash
echo "=== INICIANDO BUILD PERSONALIZADO ==="

# Verificar Node.js
echo "Versiones instaladas:"
node --version
npm --version

# Limpiar cache y módulos previos
echo "Limpiando cache..."
rm -rf node_modules/.cache
rm -rf public/build/*
mkdir -p public/build

# Instalar dependencias
echo "Instalando dependencias..."
npm ci --no-audit --prefer-offline

# Verificar que las dependencias están instaladas
echo "Verificando dependencias de Vite..."
if ! npm list vite >/dev/null 2>&1; then
    echo "Reinstalando Vite..."
    npm install vite@^6.0.0 --no-save
fi

# Build de Vite con configuración específica
echo "Ejecutando Vite build..."
export NODE_ENV=production
export NODE_OPTIONS="--max-old-space-size=4096"

# Intentar build normal
if npm run build; then
    echo "✅ Build de Vite exitoso"
else
    echo "❌ Error en build, usando comando de fallback..."
    # Usar comando Laravel personalizado como fallback
    php artisan vite:fix-manifest --force
fi

# Verificar resultado
echo "Verificando build..."
ls -la public/build/

if [ -f "public/build/manifest.json" ]; then
    echo "✅ Manifest encontrado:"
    cat public/build/manifest.json | head -20
else
    echo "❌ Manifest no encontrado, ejecutando fix..."
    php artisan vite:fix-manifest --force
fi

# Storage link
echo "Creando storage link..."
php artisan storage:link || echo "Storage link ya existe"

# Optimizar Laravel
echo "Optimizando Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== BUILD COMPLETADO ==="
