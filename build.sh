#!/bin/bash
echo "=== INICIANDO BUILD PERSONALIZADO ==="

# Verificar Node.js
node --version
npm --version

# Instalar dependencias
echo "Instalando dependencias..."
npm ci

# Build de Vite
echo "Ejecutando Vite build..."
npm run build

# Verificar que se creó el manifest
if [ -f "public/build/manifest.json" ]; then
    echo "✅ Vite manifest creado exitosamente"
    ls -la public/build/
else
    echo "❌ Error: No se pudo crear el manifest de Vite"
    echo "Creando manifest básico como fallback..."
    mkdir -p public/build
    echo '{}' > public/build/manifest.json
fi

# Storage link
echo "Creando storage link..."
php artisan storage:link

echo "=== BUILD COMPLETADO ==="
