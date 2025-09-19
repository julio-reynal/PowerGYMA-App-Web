# 🚀 Configuración Correcta para Railway

## ⚠️ ERROR NIXPACKS SOLUCIONADO

El error que experimentaste se debe a un problema con el archivo `nixpacks.toml`. La solución es **NO usar** `nixpacks.toml` y dejar que Railway detecte automáticamente el proyecto.

## ✅ Variables de Entorno CORRECTAS para Railway

### 1. Variables de Build (CRÍTICAS):
```bash
# Build simplificado (SIN archivos .toml)
NIXPACKS_BUILD_CMD=composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan storage:link

# Start command con cachés en runtime
NIXPACKS_START_CMD=php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=$PORT

# Versiones específicas
PHP_VERSION=8.2
NODE_VERSION=18
```

### 2. Variables de la Aplicación:
```bash
APP_NAME=Power GYMA
APP_ENV=production
APP_KEY=base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs=
APP_DEBUG=false
APP_URL=https://TU-DOMINIO.railway.app

# Localización
APP_LOCALE=es
APP_FALLBACK_LOCALE=en
BCRYPT_ROUNDS=12

# Database (Railway auto-completa)
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

# Assets
VITE_APP_NAME=Power GYMA
```

## 🔧 Pasos para Corregir el Error:

### 1. **Eliminar archivos problemáticos**
- [x] `nixpacks.toml` - YA ELIMINADO

### 2. **Actualizar variables en Railway**
1. Ve a tu proyecto Railway
2. Click en "Variables"
3. Actualiza `NIXPACKS_BUILD_CMD` con el valor de arriba
4. Actualiza `NIXPACKS_START_CMD` con el valor de arriba
5. Asegúrate de que `APP_URL` tenga tu dominio real

### 3. **Subir cambios**
```bash
git add .
git commit -m "fix: remove nixpacks.toml and simplify build process"
git push origin main
```

### 4. **Forzar rebuild**
```bash
railway redeploy
```

## ✨ Por qué esta configuración funciona:

1. **Sin nixpacks.toml**: Railway detecta automáticamente Laravel y Node.js
2. **Build simplificado**: Solo instala dependencias y compila assets
3. **Cachés en runtime**: Los cachés de Laravel se crean al iniciar, no durante build
4. **Comando específico**: Usa comandos exactos que funcionan en el entorno Railway

## 🎯 Monitorear el Deploy:

```bash
railway logs --tail
```

Deberías ver algo como:
```
Installing PHP dependencies...
Installing Node.js dependencies...
Building assets with Vite...
Starting Laravel application...
```

## 🚨 Si sigue fallando:

1. **Verificar que no haya archivos .toml**:
```bash
ls -la *.toml
# No debe mostrar nixpacks.toml
```

2. **Reset completo**:
```bash
railway redeploy --force
```

3. **Verificar logs específicos**:
```bash
railway logs --deployment
```
