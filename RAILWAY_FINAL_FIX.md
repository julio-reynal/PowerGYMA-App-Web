# 🚨 SOLUCIÓN DEFINITIVA - Conflicto Node.js

## El Problema:
Railway está detectando dos versiones de Node.js (18 y 20) causando conflicto en Nixpacks.

## ✅ SOLUCIÓN INMEDIATA:

### 1. Variables a MANTENER en Railway:
```bash
# SOLO estas dos variables de build
NIXPACKS_BUILD_CMD=composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan storage:link

NIXPACKS_START_CMD=php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=$PORT

# Variables de la app
APP_NAME=Power GYMA
APP_ENV=production
APP_KEY=base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs=
APP_DEBUG=false
APP_URL=https://TU-DOMINIO.railway.app

# Database (auto-generadas por Railway)
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

# Localización
APP_LOCALE=es
APP_FALLBACK_LOCALE=en
BCRYPT_ROUNDS=12

# Assets
VITE_APP_NAME=Power GYMA
```

### 2. Variables a ELIMINAR (si existen):
```bash
# BORRAR ESTAS si están en Railway:
PHP_VERSION
NODE_VERSION
NIXPACKS_PHP_VERSION
NIXPACKS_NODE_VERSION
```

### 3. ¿Cómo actualizar en Railway?

1. **Ve a tu proyecto Railway**
2. **Click en "Variables"**
3. **ELIMINA** cualquier variable de versión (PHP_VERSION, NODE_VERSION)
4. **ACTUALIZA** NIXPACKS_BUILD_CMD con el valor de arriba
5. **ACTUALIZA** NIXPACKS_START_CMD con el valor de arriba
6. **AGREGA** APP_URL con tu dominio real

### 4. Forzar rebuild limpio:
```bash
# Opción 1: Desde Railway Dashboard
# Ve a "Deployments" → Click "Deploy"

# Opción 2: Desde CLI
railway redeploy
```

## 🎯 ¿Por qué funciona esta solución?

1. **Sin versiones específicas**: Railway detecta automáticamente las mejores versiones
2. **Build mínimo**: Solo instala dependencias y compila assets
3. **Cachés en runtime**: Los cachés de Laravel se crean al iniciar, no durante build
4. **Sin conflictos**: Una sola versión de Node.js detectada automáticamente

## 📋 Checklist de verificación:

- [ ] Eliminadas variables PHP_VERSION y NODE_VERSION
- [ ] NIXPACKS_BUILD_CMD actualizada
- [ ] NIXPACKS_START_CMD actualizada  
- [ ] APP_URL configurada con dominio real
- [ ] Forzado nuevo deployment
- [ ] Logs monitoreados: `railway logs --tail`

## 🔍 Logs exitosos esperados:

```
Installing PHP dependencies with Composer...
Installing Node.js dependencies...
Building assets with Vite...
Linking storage directory...
Starting application...
Running migrations...
Caching configuration...
Server started on port 8000
```

## ⚠️ Si SIGUE fallando:

### Opción alternativa - Usar Procfile:
1. Eliminar TODAS las variables NIXPACKS_*
2. Dejar que Railway use el Procfile automáticamente

Railway detectará Laravel y usará configuración por defecto.
