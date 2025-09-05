# Power GYMA - Laravel Application

## Variables de Entorno para Railway

### Copiar y pegar en Railway Variables:

```bash
# Build Configuration (CRÍTICO) - ACTUALIZADO
NIXPACKS_BUILD_CMD=composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link && php artisan optimize

NIXPACKS_START_CMD=php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT

# Runtime Versions
PHP_VERSION=8.2
NODE_VERSION=18

# Application
APP_NAME=Power GYMA
APP_ENV=production
APP_KEY=base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs=
APP_DEBUG=false
APP_LOCALE=es
APP_FALLBACK_LOCALE=en
BCRYPT_ROUNDS=12

# Database (Railway auto-completa estas)
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}

# Session & Cache
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=warning

# Mail (opcional - configura con tus datos)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@powergyma.com
MAIL_FROM_NAME=Power GYMA

# Assets
VITE_APP_NAME=Power GYMA
```

## Comandos Railway CLI de Referencia:

```bash
# Setup inicial
npm install -g @railway/cli
railway login
railway link

# Monitoreo en tiempo real
railway logs --tail
railway status
railway ps

# Comandos de mantenimiento
railway run php artisan migrate --force
railway run php artisan optimize
railway run php artisan cache:clear
railway redeploy

# Gestión de variables
railway variables
railway variables set APP_DEBUG=false

# Conexiones
railway connect mysql
railway open
```

## Proceso de Deployment Paso a Paso:

1. **Preparar código**: `git add . && git commit -m "deploy" && git push`
2. **Crear proyecto en Railway**: Deploy from GitHub repo
3. **Agregar MySQL**: Add Database > MySQL
4. **Configurar variables**: Copiar las variables de arriba
5. **Verificar deployment**: `railway logs --tail`

## Comandos de Emergencia:

```bash
# Reset completo de cachés
railway run php artisan optimize:clear

# Verificar conectividad
railway run php artisan migrate:status

# Backup rápido
railway run mysqldump -h $MYSQL_HOST -P $MYSQL_PORT -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE > backup.sql
```
