#!/bin/bash

# Script de deployment para Railway
# Este script se ejecuta después del build exitoso

echo "🚀 Iniciando deployment de Power GYMA..."

# Esperar a que la base de datos esté disponible
echo "⏳ Esperando conexión a base de datos..."
php artisan migrate:status --no-ansi || echo "❌ Error de conexión a BD, continuando..."

# Ejecutar migraciones
echo "📊 Ejecutando migraciones..."
php artisan migrate --force --no-ansi

# Ejecutar seeders si es el primer deployment
if [ "$FIRST_DEPLOY" = "true" ]; then
    echo "🌱 Ejecutando seeders iniciales..."
    php artisan db:seed --force --no-ansi
fi

# Crear enlaces simbólicos
echo "🔗 Creando enlaces de storage..."
php artisan storage:link --no-ansi

# Limpiar y optimizar cachés
echo "🧹 Optimizando cachés..."
php artisan optimize --no-ansi

# Verificar estado de la aplicación
echo "✅ Verificando estado de la aplicación..."
php artisan about --no-ansi

echo "🎉 Deployment completado exitosamente!"

# Iniciar servidor
echo "🌐 Iniciando servidor..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
