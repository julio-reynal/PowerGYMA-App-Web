# 🚨 VITE MANIFEST ERROR - SOLUCIÓN DEFINITIVA

## ❌ PROBLEMA:
```
Vite manifest not found at: /app/public/build/manifest.json
```

## 📋 CAUSA:
**Railway no está ejecutando `npm run build` durante el deploy**

## 🔧 SOLUCIÓN PASO A PASO:

### PASO 1: VERIFICAR Variables en Railway Dashboard
**Ve a Railway Dashboard → Variables y ASEGÚRATE que estas variables estén configuradas:**

```bash
NODE_VERSION=20.19.0
NIXPACKS_NODE_VERSION=20.19.0
NIXPACKS_BUILD_CMD=npm run build && php artisan storage:link
```

### PASO 2: SI NO ESTÁN - Aplicar TODAS estas variables:

```bash
APP_NAME=Power GYMA
APP_ENV=production
APP_KEY=base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs=
APP_DEBUG=true
APP_URL=https://powergyma-app-web-production.up.railway.app
ASSET_URL=https://powergyma-app-web-production.up.railway.app
NODE_VERSION=20.19.0
NODE_ENV=production
NIXPACKS_NODE_VERSION=20.19.0
FORCE_HTTPS=true
TRUST_PROXIES=*
NIXPACKS_INSTALL_CMD=composer install --no-dev --optimize-autoloader && npm install --include=dev
NIXPACKS_BUILD_CMD=npm run build && php artisan storage:link
DB_CONNECTION=mysql
DB_HOST=mysql.railway.internal
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=XmAYhysjQKuqurqFzBLaACtbNeUCjWqf
APP_LOCALE=es
APP_FALLBACK_LOCALE=en
LOG_CHANNEL=stack
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local
VITE_APP_NAME=Power GYMA
```

### PASO 3: HACER DEPLOY
Después de aplicar las variables, hacer **Deploy** en Railway.

### PASO 4: VERIFICAR Build Logs
En Railway Dashboard → Deployments → Ver los logs para confirmar que se ejecute:
- ✅ `npm install --include=dev`
- ✅ `npm run build`
- ✅ `php artisan storage:link`

## 🎯 QUE DEBE APARECER en los logs:
```
vite v6.x.x building for production...
✓ XX modules transformed.
public/build/.vite/manifest.json created
✓ built in XXXms
```

## ⚠️ SI EL ERROR PERSISTE:

### OPCIÓN A: Forzar rebuild
1. Ve a Railway Dashboard → Settings
2. Buscar **Clear Build Cache** o similar
3. Hacer deploy nuevamente

### OPCIÓN B: Crear nuevo proyecto Railway
1. Eliminar proyecto actual en Railway
2. Crear nuevo proyecto
3. Conectar repositorio GitHub
4. Aplicar variables desde cero

## 🚀 RESULTADO ESPERADO:
- ✅ `/app/public/build/manifest.json` se genera
- ✅ Assets CSS/JS disponibles
- ✅ Login page funciona correctamente
