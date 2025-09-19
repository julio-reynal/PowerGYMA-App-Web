#!/bin/bash
echo "=== BUILD SIMPLE PARA RAILWAY ==="

# Asegurar permisos
chmod +x build-simple.sh

# Limpiar build anterior
echo "Limpiando build anterior..."
rm -rf public/build/*
mkdir -p public/build

# Variables de entorno
export NODE_ENV=production
export NODE_OPTIONS="--max-old-space-size=4096"

# Build directo con Vite
echo "Ejecutando build de Vite..."
npx vite build

# Fix manifest manualmente
echo "Moviendo manifest..."
if [ -f "public/build/.vite/manifest.json" ]; then
    mv "public/build/.vite/manifest.json" "public/build/manifest.json"
    echo "✅ Manifest movido correctamente"
else
    echo "ℹ️ Manifest ya está en la ubicación correcta o no se encontró"
fi

# Verificar resultado
echo "Verificando resultado:"
ls -la public/build/

if [ -f "public/build/manifest.json" ]; then
    echo "✅ Build completado exitosamente"
    head -5 "public/build/manifest.json"
else
    echo "❌ Error: No se encontró manifest.json"
    exit 1
fi

echo "=== BUILD SIMPLE COMPLETADO ==="
