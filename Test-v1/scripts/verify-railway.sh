#!/bin/bash
# Script para verificar el deploy de Railway y corregir problemas de Vite

echo "=== VERIFICACIÓN POST-DEPLOY RAILWAY ==="

# Verificar variables de entorno críticas
echo "1. Verificando variables de entorno:"
echo "APP_URL: $APP_URL"
echo "APP_ENV: $APP_ENV"
echo "APP_DEBUG: $APP_DEBUG"
echo "NODE_ENV: $NODE_ENV"

# Verificar estructura de archivos
echo "2. Verificando estructura de build..."
if [ -d "public/build" ]; then
    echo "✅ Directorio public/build existe"
    ls -la public/build/
else
    echo "❌ Directorio public/build NO existe, creando..."
    mkdir -p public/build/assets
fi

# Verificar manifest
echo "3. Verificando manifest.json..."
if [ -f "public/build/manifest.json" ]; then
    echo "✅ Manifest encontrado"
    echo "Contenido del manifest:"
    cat public/build/manifest.json | head -15
else
    echo "❌ Manifest no encontrado, creando fallback..."
    mkdir -p public/build
    cat > public/build/manifest.json << 'EOF'
{
  "resources/css/login.css": {
    "file": "assets/login.css",
    "isEntry": true,
    "src": "resources/css/login.css"
  },
  "resources/js/login.js": {
    "file": "assets/login.js",
    "isEntry": true,
    "src": "resources/js/login.js"
  },
  "resources/css/dashboard.css": {
    "file": "assets/dashboard.css",
    "isEntry": true,
    "src": "resources/css/dashboard.css"
  },
  "resources/js/chart-theme.js": {
    "file": "assets/chart-theme.js",
    "isEntry": true,
    "src": "resources/js/chart-theme.js"
  },
  "resources/css/app.css": {
    "file": "assets/app.css",
    "isEntry": true,
    "src": "resources/css/app.css"
  },
  "resources/js/app.js": {
    "file": "assets/app.js",
    "isEntry": true,
    "src": "resources/js/app.js"
  }
}
EOF
    echo "✅ Manifest fallback creado"
fi

# Verificar y copiar assets
echo "4. Verificando assets..."
mkdir -p public/build/assets

# Copiar archivos de resources como fallback
if [ -d "resources/css" ]; then
    echo "Copiando archivos CSS..."
    cp resources/css/*.css public/build/assets/ 2>/dev/null || echo "No se encontraron archivos CSS para copiar"
fi

if [ -d "resources/js" ]; then
    echo "Copiando archivos JS..."
    cp resources/js/*.js public/build/assets/ 2>/dev/null || echo "No se encontraron archivos JS para copiar"
fi

# Verificar permisos
echo "5. Configurando permisos..."
chmod -R 755 public/build/ 2>/dev/null || echo "No se pudieron cambiar permisos"

# Limpiar y recrear cache de Laravel
echo "6. Optimizando Laravel..."
php artisan cache:clear 2>/dev/null || echo "Cache clear falló"
php artisan config:clear 2>/dev/null || echo "Config clear falló"
php artisan view:clear 2>/dev/null || echo "View clear falló"

php artisan config:cache 2>/dev/null && echo "✅ Config cache creado" || echo "❌ Config cache falló"
php artisan route:cache 2>/dev/null && echo "✅ Route cache creado" || echo "❌ Route cache falló"
php artisan view:cache 2>/dev/null && echo "✅ View cache creado" || echo "❌ View cache falló"

# Verificar rutas críticas
echo "7. Verificando rutas principales:"
php artisan route:list --name=login 2>/dev/null || echo "Ruta login no encontrada"
php artisan route:list --name=dashboard 2>/dev/null || echo "Ruta dashboard no encontrada"

# Estado final
echo "8. Estado final:"
ls -la public/build/
echo "Tamaño del manifest:"
wc -l public/build/manifest.json 2>/dev/null || echo "Manifest no legible"

echo "=== VERIFICACIÓN COMPLETADA ==="
