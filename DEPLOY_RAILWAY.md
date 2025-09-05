# Guía de Despliegue en Railway - Power GYMA

Esta guía te ayudará a desplegar tu aplicación Laravel Power GYMA en Railway usando Nixpacks (recomendado para Laravel).

## 📋 Prerrequisitos

- Cuenta en [Railway](https://railway.app)
- Git instalado en tu sistema
- Proyecto Laravel funcionando localmente
- Cuenta de GitHub (recomendado)
- Node.js y NPM instalados localmente

## 🚀 Pasos para el Despliegue

### 1. Preparar el Proyecto para Railway con Nixpacks

#### 1.1 Configurar variables de build (Recomendado)

Railway detectará automáticamente tu proyecto Laravel y usará Nixpacks. Para optimizar el proceso de build, agrega estas variables de entorno en Railway:

```bash
# Variable de build personalizada para Railway
NIXPACKS_BUILD_CMD="composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link"

# Variable de start command
NIXPACKS_START_CMD="php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"
```

#### 1.2 Crear archivo nixpacks.toml (Opcional pero recomendado)

Crea el archivo `nixpacks.toml` en la raíz del proyecto para mayor control:

```toml
[variables]
NODE_VERSION = "18"
PHP_VERSION = "8.2"

[phases.setup]
nixPkgs = ["nodejs", "npm"]

[phases.install]
cmds = [
  "composer install --no-dev --optimize-autoloader",
  "npm ci --production=false"
]

[phases.build]
cmds = [
  "npm run build",
  "php artisan config:cache",
  "php artisan route:cache", 
  "php artisan view:cache",
  "php artisan storage:link"
]

[start]
cmd = "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"
```

#### 1.3 Alternativa: Usar Procfile (Método tradicional)

Si prefieres usar Procfile en lugar de Nixpacks:

```bash
# Crear Procfile
echo 'web: php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT' > Procfile
```

#### 1.4 Optimizar composer.json para producción

Asegúrate de que tu `composer.json` tenga las optimizaciones correctas:

```json
{
  "scripts": {
    "post-autoload-dump": [
      "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
      "@php artisan package:discover --ansi"
    ],
    "post-update-cmd": [
      "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
    ],
    "post-root-package-install": [
      "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
    ],
    "post-create-project-cmd": [
      "@php artisan key:generate --ansi",
      "@php -r \"file_exists('database/database.sqlite') || touch('database/database.sqlite');\"",
      "@php artisan migrate --graceful --ansi"
    ],
    "post-install-cmd": [
      "@php artisan clear-compiled",
      "@php artisan cache:clear",
      "@php artisan config:cache"
    ]
  },
  "config": {
    "optimize-autoloader": true,
    "preferred-install": "dist",
    "sort-packages": true,
    "platform-check": false,
    "allow-plugins": {
      "pestphp/pest-plugin": true,
      "php-http/discovery": true
    }
  }
}
```

### 2. Configurar Variables de Entorno para Railway

#### 2.1 Variables de entorno principales para Railway

En lugar de crear un archivo `.env.railway`, configurarás las variables directamente en Railway. Aquí están las variables esenciales:

**Variables de Build (Nixpacks):**
```bash
NIXPACKS_BUILD_CMD="composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link"

NIXPACKS_START_CMD="php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"

# Opcional: Especificar versiones
PHP_VERSION="8.2"
NODE_VERSION="18"
```

**Variables de la aplicación:**
```bash
# App Configuration
APP_NAME="Power GYMA"
APP_ENV=production
APP_KEY=base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs=
APP_DEBUG=false
APP_URL=https://$RAILWAY_PUBLIC_DOMAIN

# Localization
APP_LOCALE=es
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=es_ES

# Security
BCRYPT_ROUNDS=12

# Logging
LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=warning

# Database (Railway MySQL)
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}
DB_URL=${{MySQL.DATABASE_URL}}

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

# Cache
CACHE_STORE=database
CACHE_PREFIX=power_gyma_cache

# Queue
QUEUE_CONNECTION=database

# Storage
FILESYSTEM_DISK=local

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@powergyma.com"
MAIL_FROM_NAME="${APP_NAME}"

# Vite
VITE_APP_NAME="${APP_NAME}"
```

### 3. Optimizar Laravel para Railway

#### 3.1 Configurar database.php para Railway

Asegúrate de que `config/database.php` esté optimizado:

```php
'mysql' => [
    'driver' => 'mysql',
    'url' => env('DB_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'laravel'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ]) : [],
],
```

#### 3.2 Configurar logging para Railway

Actualiza `config/logging.php` para Railway:

```php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => env('LOG_STACK', 'single'),
        'ignore_exceptions' => false,
    ],

    'single' => [
        'driver' => 'single',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'replace_placeholders' => true,
    ],
    
    // Agregar canal para Railway
    'railway' => [
        'driver' => 'single',
        'path' => 'php://stdout',
        'level' => env('LOG_LEVEL', 'debug'),
        'replace_placeholders' => true,
    ],
],
```

#### 3.3 Ajustar configuración de sesión

En `config/session.php`:

```php
'driver' => env('SESSION_DRIVER', 'database'),
'lifetime' => env('SESSION_LIFETIME', 120),
'expire_on_close' => false,
'encrypt' => env('SESSION_ENCRYPT', false),
'files' => storage_path('framework/sessions'),
'connection' => env('SESSION_CONNECTION'),
'table' => 'sessions',
'store' => env('SESSION_STORE'),
'lottery' => [2, 100],
'cookie' => env(
    'SESSION_COOKIE',
    Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
),
'path' => '/',
'domain' => env('SESSION_DOMAIN'),
'secure' => env('SESSION_SECURE_COOKIE', true),
'http_only' => true,
'same_site' => 'lax',
'partitioned' => false,
```

### 4. Preparar Assets y Dependencies

#### 4.1 Optimizar package.json

Asegúrate de que tu `package.json` esté optimizado:

```json
{
  "private": true,
  "type": "module",
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "preview": "vite preview"
  },
  "devDependencies": {
    "@tailwindcss/vite": "^4.0.0",
    "axios": "^1.11.0",
    "laravel-vite-plugin": "^2.0.0",
    "tailwindcss": "^4.0.0",
    "vite": "^7.0.4"
  },
  "engines": {
    "node": ">=18.0.0",
    "npm": ">=9.0.0"
  }
}
```

#### 4.2 Verificar configuración de Vite

Revisa tu `vite.config.js`:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
});
```

#### 4.3 Compilar assets localmente (Opcional)

```bash
# Instalar dependencias
npm install

# Compilar para producción
npm run build

# Verificar que se creó la carpeta public/build
ls -la public/build/
```

### 5. Comandos Git para Subir a GitHub

#### 5.1 Preparar .gitignore optimizado

```bash
# Crear/actualizar .gitignore
cat > .gitignore << 'EOF'
# Dependencies
/node_modules
/vendor

# Environment files
.env
.env.*
!.env.example

# Build outputs
/public/build
/public/hot
/storage/*.key

# IDE files
.vscode/
.idea/
*.swp
*.swo

# OS generated files
.DS_Store
.DS_Store?
._*
.Spotlight-V100
.Trashes
ehthumbs.db
Thumbs.db

# Laravel specific
/bootstrap/cache/*.php
/storage/framework/cache/data/*
/storage/framework/sessions/*
/storage/framework/views/*
/storage/logs/*
/storage/debugbar/*

# Testing
/coverage
/.nyc_output
/.phpunit.cache
/phpunit.xml

# Composer
/vendor/
composer.phar

# NPM
npm-debug.log*
yarn-debug.log*
yarn-error.log*

# Railway
.railway/
EOF
```

#### 5.2 Comandos Git

```bash
# Inicializar Git (si no existe)
git init

# Agregar todos los archivos
git add .

# Hacer commit inicial
git commit -m "feat: initial commit - Power GYMA Laravel App ready for Railway deployment"

# Conectar con repositorio remoto (reemplaza con tu URL)
git remote add origin https://github.com/tu-usuario/power-gyma.git

# Crear y cambiar a rama main
git branch -M main

# Subir código
git push -u origin main
```

#### 5.3 Comandos para actualizaciones futuras

```bash
# Para futuras actualizaciones
git add .
git commit -m "feat: descripción de los cambios"
git push origin main
```

### 6. Desplegar en Railway (Método Nixpacks)

#### 6.1 Crear proyecto en Railway

1. Ve a [Railway](https://railway.app) y haz login
2. Haz clic en **"New Project"**
3. Selecciona **"Deploy from GitHub repo"**
4. Conecta tu cuenta de GitHub si no lo has hecho
5. Selecciona el repositorio **"power-gyma"**
6. Railway detectará automáticamente que es un proyecto Laravel

#### 6.2 Configurar servicios automáticamente

**Railway detectará automáticamente:**
- Proyecto Laravel con PHP
- Dependencias de Node.js
- Necesidad de base de datos

**Agregar Base de Datos MySQL:**

1. En el dashboard del proyecto, haz clic en **"+ New"**
2. Selecciona **"Database"** → **"Add MySQL"**
3. Railway creará automáticamente las variables de entorno:
   - `MYSQL_HOST`
   - `MYSQL_PORT` 
   - `MYSQL_DATABASE`
   - `MYSQL_USER`
   - `MYSQL_PASSWORD`
   - `DATABASE_URL`

#### 6.3 Configurar variables de entorno

En el servicio de tu aplicación Laravel:

1. Ve a la pestaña **"Variables"**
2. Haz clic en **"+ New Variable"**
3. Agrega estas variables una por una:

**Variables de Build (Críticas):**
```env
NIXPACKS_BUILD_CMD=composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link

NIXPACKS_START_CMD=php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT

PHP_VERSION=8.2
NODE_VERSION=18
```

**Variables de la aplicación:**
```env
APP_NAME=Power GYMA
APP_ENV=production
APP_KEY=base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs=
APP_DEBUG=false
APP_LOCALE=es
APP_FALLBACK_LOCALE=en
BCRYPT_ROUNDS=12
LOG_CHANNEL=stack
LOG_LEVEL=warning
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local
```

**Variables de base de datos (Automáticas):**
```env
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}
```

**Variables de correo:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@powergyma.com
MAIL_FROM_NAME=Power GYMA
```

**Variables de Vite:**
```env
VITE_APP_NAME=Power GYMA
```

#### 6.4 Configurar dominio

1. En **"Settings"** del servicio
2. Ve a **"Networking"**
3. Haz clic en **"Generate Domain"** para obtener un dominio gratuito
4. Copia la URL generada y actualiza la variable `APP_URL`

#### 6.5 Forzar redeploy

1. Ve a la pestaña **"Deployments"**
2. Haz clic en **"Deploy"** para forzar un nuevo despliegue
3. Observa los logs en tiempo real

### 7. Verificación y Comandos Post-Despliegue

#### 7.1 Instalar Railway CLI (Recomendado)

```bash
# Instalar Railway CLI globalmente
npm install -g @railway/cli

# Verificar instalación
railway --version

# Login a Railway
railway login

# Conectar al proyecto (ejecutar en la carpeta del proyecto)
railway link
```

#### 7.2 Comandos útiles con Railway CLI

```bash
# Ver logs en tiempo real
railway logs

# Ver logs específicos del servicio web
railway logs --service web

# Ver variables de entorno
railway variables

# Ejecutar comandos remotos en el servidor
railway run php artisan --version

# Ver el estado del proyecto
railway status

# Abrir la aplicación en el navegador
railway open
```

#### 7.3 Comandos de verificación y mantenimiento

```bash
# Ejecutar migraciones manualmente
railway run php artisan migrate --force

# Ejecutar seeders (si es necesario)
railway run php artisan db:seed --force

# Limpiar cachés
railway run php artisan cache:clear
railway run php artisan config:clear
railway run php artisan route:clear
railway run php artisan view:clear

# Recrear cachés optimizados
railway run php artisan config:cache
railway run php artisan route:cache
railway run php artisan view:cache

# Crear enlace simbólico de storage
railway run php artisan storage:link

# Verificar configuración
railway run php artisan config:show database
railway run php artisan env

# Ver información de la base de datos
railway run php artisan tinker
# Dentro de tinker: DB::connection()->getPdo();
```

#### 7.4 Monitorear el despliegue

```bash
# Ver logs de build en tiempo real
railway logs --deployment

# Ver logs de la aplicación
railway logs --service web --tail

# Ver estado de los servicios
railway ps
```

### 8. Solución de Problemas Comunes

#### 8.1 Error 500 - Internal Server Error

```bash
# Ver logs detallados
railway logs --tail

# Verificar configuración de Laravel
railway run php artisan config:show

# Limpiar todos los cachés
railway run php artisan optimize:clear

# Verificar que las migraciones se ejecutaron
railway run php artisan migrate:status

# Verificar conexión a base de datos
railway run php artisan tinker
# En tinker: DB::connection()->getPdo();
```

#### 8.2 Error de Build/Compilación

```bash
# Verificar variables de build
railway variables | grep NIXPACKS

# Ver logs de build específicos
railway logs --deployment

# Forzar rebuild
railway redeploy

# Verificar versiones de PHP y Node
railway run php --version
railway run node --version
railway run npm --version
```

#### 8.3 Problemas con Assets/Vite

```bash
# Verificar que los assets se compilaron
railway run ls -la public/build/

# Recompilar assets remotamente
railway run npm run build

# Verificar configuración de Vite
railway run cat vite.config.js

# Limpiar caché de Vite
railway run npm run build -- --force
```

#### 8.4 Problemas de Base de Datos

```bash
# Verificar conexión
railway run php artisan migrate:status

# Ejecutar migraciones frescas (CUIDADO: borra datos)
railway run php artisan migrate:fresh --force

# Verificar configuración de base de datos
railway run php artisan config:show database

# Conectar directamente a MySQL
railway connect mysql
```

#### 8.5 Problemas de Permisos/Storage

```bash
# Recrear enlace simbólico
railway run php artisan storage:link

# Verificar permisos (en caso de usar filesystem)
railway run ls -la storage/

# Limpiar logs
railway run php artisan log:clear
```

#### 8.6 Variables de Entorno

```bash
# Ver todas las variables
railway variables

# Verificar variables específicas
railway run echo $APP_KEY
railway run echo $DB_HOST

# Recargar variables después de cambios
railway redeploy
```

### 9. Comandos de Mantenimiento y Actualizaciones

#### 9.1 Actualizar aplicación

```bash
# Hacer cambios en código local
git add .
git commit -m "feat: nueva funcionalidad implementada"
git push origin main

# Railway auto-desplegará los cambios automáticamente
# Ver el progreso del deploy
railway logs --tail
```

#### 9.2 Comandos de mantenimiento

```bash
# Backup de base de datos
railway run mysqldump -h $MYSQL_HOST -P $MYSQL_PORT -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE > backup_$(date +%Y%m%d_%H%M%S).sql

# Restaurar backup
railway run mysql -h $MYSQL_HOST -P $MYSQL_PORT -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE < backup.sql

# Optimizar base de datos
railway run php artisan optimize

# Limpiar logs antiguos
railway run php artisan log:clear

# Ver espacio utilizado
railway run df -h

# Ver uso de memoria
railway run free -h
```

#### 9.3 Comandos de desarrollo

```bash
# Ejecutar comandos Artisan remotos
railway run php artisan make:controller NuevoController
railway run php artisan make:model NuevoModel -m
railway run php artisan make:migration crear_nueva_tabla

# Ejecutar tests remotos
railway run php artisan test

# Inspeccionar configuración
railway run php artisan config:show
railway run php artisan route:list
railway run php artisan env
```

### 10. Monitoreo y Logs

#### 10.1 Comandos de logs

```bash
# Ver logs en tiempo real
railway logs --tail

# Ver logs de un periodo específico
railway logs --since 1h

# Ver logs de deployment
railway logs --deployment

# Filtrar logs por nivel
railway logs --filter error
railway logs --filter warning

# Exportar logs
railway logs > logs_$(date +%Y%m%d).txt
```

#### 10.2 Métricas y monitoreo

```bash
# Ver uso de recursos
railway ps

# Ver información del proyecto
railway status

# Ver información de servicios
railway services

# Ver variables de entorno
railway variables

# Ver dominios
railway domains
```

#### 10.3 Configurar alertas (Web UI)

1. Ve al dashboard de Railway
2. Selecciona tu proyecto
3. Ve a **"Settings"** → **"Notifications"**
4. Configura webhooks o integraciones para:
   - Deployments fallidos
   - Uso alto de recursos
   - Errores de aplicación

### 11. Mejores Prácticas de Producción

#### 11.1 Seguridad

```bash
# Verificar configuración de seguridad
railway run php artisan config:show app | grep -i debug
railway run php artisan config:show app | grep -i env

# Variables críticas a verificar
railway variables | grep APP_DEBUG  # Debe ser false
railway variables | grep APP_ENV    # Debe ser production
railway variables | grep APP_KEY    # Debe estar configurada
```

#### 11.2 Performance

```bash
# Habilitar cachés de producción
railway run php artisan config:cache
railway run php artisan route:cache
railway run php artisan view:cache
railway run php artisan event:cache

# Verificar cachés activos
railway run php artisan config:show cache
railway run php artisan route:list --compact
```

#### 11.3 Respaldos automáticos

```bash
# Script de backup (ejecutar localmente con cron)
#!/bin/bash
BACKUP_DATE=$(date +%Y%m%d_%H%M%S)
railway run mysqldump -h $MYSQL_HOST -P $MYSQL_PORT -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE > "backup_powergyma_${BACKUP_DATE}.sql"
echo "Backup creado: backup_powergyma_${BACKUP_DATE}.sql"
```

## ✅ Checklist de Despliegue Completo

### Preparación Local
- [ ] Proyecto Laravel funcionando localmente
- [ ] Todas las dependencias instaladas (`composer install`, `npm install`)
- [ ] Assets compilados localmente (`npm run build`)
- [ ] Archivo `.gitignore` optimizado
- [ ] Variables de entorno locales configuradas

### Configuración de Railway
- [ ] Cuenta de Railway creada
- [ ] Repositorio de GitHub creado y conectado
- [ ] Proyecto desplegado desde GitHub en Railway
- [ ] Servicio MySQL agregado

### Variables de Entorno Críticas
- [ ] `NIXPACKS_BUILD_CMD` configurada correctamente
- [ ] `NIXPACKS_START_CMD` configurada
- [ ] `APP_KEY` generada y configurada
- [ ] `APP_ENV=production` configurada
- [ ] `APP_DEBUG=false` configurada
- [ ] Variables de base de datos conectadas (`DB_*`)
- [ ] Variables de correo configuradas (si aplica)

### Verificación Post-Despliegue
- [ ] Aplicación carga sin errores 500
- [ ] Base de datos conectada correctamente
- [ ] Migraciones ejecutadas (`railway run php artisan migrate:status`)
- [ ] Assets cargando correctamente
- [ ] Funcionalidades principales funcionando
- [ ] Logs sin errores críticos (`railway logs`)

### Optimización
- [ ] Cachés de Laravel habilitados
- [ ] Storage link creado
- [ ] Configuración de producción verificada
- [ ] Dominio personalizado configurado (opcional)

## 🔧 Comandos de Referencia Rápida

### Comandos Esenciales de Railway CLI

```bash
# Instalación y setup
npm install -g @railway/cli
railway login
railway link

# Monitoreo
railway logs --tail                    # Ver logs en tiempo real
railway logs --deployment             # Ver logs de deployment
railway status                        # Estado del proyecto
railway ps                            # Uso de recursos

# Ejecución remota
railway run php artisan migrate --force
railway run php artisan cache:clear
railway run php artisan config:cache
railway run php artisan storage:link

# Gestión
railway variables                      # Ver variables de entorno
railway redeploy                      # Forzar nuevo deployment
railway open                         # Abrir app en navegador
railway connect mysql                # Conectar a base de datos
```

### Variables de Entorno Críticas para Copiar/Pegar

```bash
# Build Configuration
NIXPACKS_BUILD_CMD=composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link
NIXPACKS_START_CMD=php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
PHP_VERSION=8.2
NODE_VERSION=18

# App Configuration
APP_NAME=Power GYMA
APP_ENV=production
APP_DEBUG=false
APP_LOCALE=es
BCRYPT_ROUNDS=12
LOG_LEVEL=warning
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Database (Auto-filled by Railway)
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}
```

### Comandos Git para Actualizaciones

```bash
# Workflow de actualización
git add .
git commit -m "feat: descripción del cambio"
git push origin main
# Railway auto-despliega automáticamente

# Ver el progreso
railway logs --tail
```

## 📞 Recursos y Soporte

### Documentación Oficial
- **Railway Docs**: https://docs.railway.app
- **Laravel Docs**: https://laravel.com/docs
- **Nixpacks Docs**: https://nixpacks.com/docs

### Solución de Problemas
1. **Error 500**: Revisar `railway logs --tail`
2. **Build Failed**: Verificar `NIXPACKS_BUILD_CMD`
3. **DB Connection**: Verificar variables `DB_*`
4. **Assets**: Verificar `npm run build` y `storage:link`

### Comandos de Emergencia

```bash
# Reset completo (CUIDADO: puede borrar datos)
railway run php artisan migrate:fresh --force
railway run php artisan config:clear
railway run php artisan cache:clear
railway redeploy

# Backup de emergencia
railway run mysqldump -h $MYSQL_HOST -P $MYSQL_PORT -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE > emergency_backup.sql
```

---

## 🎉 ¡Felicitaciones!

**Tu aplicación Power GYMA está ahora desplegada en Railway usando Nixpacks! 🚀**

### Próximos Pasos Recomendados:
1. Configurar dominio personalizado
2. Establecer respaldos automáticos
3. Configurar monitoreo de errores
4. Optimizar rendimiento según uso real
5. Configurar CI/CD pipeline (opcional)

### URL de tu aplicación:
Visita tu panel de Railway para obtener la URL pública de tu aplicación.
