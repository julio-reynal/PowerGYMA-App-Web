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

# Verificar si terser está instalado
echo "Verificando terser..."
if ! npm list terser >/dev/null 2>&1; then
    echo "Instalando terser..."
    npm install terser@^5.36.0 --no-save
fi

# Build de Vite con configuración específica
echo "Ejecutando Vite build..."
export NODE_ENV=production
export NODE_OPTIONS="--max-old-space-size=4096"

# Estrategia 1: Intentar build normal
echo "Intento 1: Build normal con terser..."
if npm run build-only; then
    echo "✅ Build de Vite exitoso"
    
    # Ejecutar fix-manifest manualmente para evitar problemas
    echo "Aplicando fix de manifest..."
    if [ -f "public/build/.vite/manifest.json" ]; then
        mv "public/build/.vite/manifest.json" "public/build/manifest.json"
        echo "✅ Manifest movido correctamente"
    else
        echo "ℹ️ Manifest ya está en la ubicación correcta"
    fi
else
    echo "❌ Build falló, intentando con configuración alternativa..."
    
    # Estrategia 2: Usar configuración sin terser
    echo "Intento 2: Build con esbuild..."
    if cp vite.config.fallback.js vite.config.temp.js && mv vite.config.js vite.config.original.js && mv vite.config.temp.js vite.config.js; then
        if npm run build-only; then
            echo "✅ Build exitoso con esbuild"
            mv vite.config.original.js vite.config.js
            
            # Fix manifest manual
            if [ -f "public/build/.vite/manifest.json" ]; then
                mv "public/build/.vite/manifest.json" "public/build/manifest.json"
                echo "✅ Manifest movido correctamente"
            fi
        else
            echo "❌ Build con esbuild falló, restaurando config..."
            mv vite.config.original.js vite.config.js
            
            # Estrategia 3: Usar comando Laravel personalizado como fallback
            echo "Intento 3: Usando comando de fallback..."
            php artisan vite:fix-manifest --force
        fi
    else
        echo "❌ Error copiando configuración, usando fallback..."
        php artisan vite:fix-manifest --force
    fi
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

echo "=== BUILD COMPLETADO ==="
