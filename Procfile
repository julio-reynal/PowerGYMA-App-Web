# Procfile para Railway (alternativa a nixpacks.toml)
# Descomenta la línea que prefieras usar

# Opción 1: Con migraciones automáticas (recomendado para producción)
web: php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT

# Opción 2: Sin migraciones automáticas (para mayor control)
# web: php artisan serve --host=0.0.0.0 --port=$PORT

# Opción 3: Usando Apache (si prefieres Apache sobre el servidor built-in)
# web: vendor/bin/heroku-php-apache2 public/

# Worker para procesar colas en background (opcional)
# worker: php artisan queue:work --tries=3 --timeout=90
