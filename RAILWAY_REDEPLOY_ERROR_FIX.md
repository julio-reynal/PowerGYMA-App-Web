# 🚨 ERROR RAILWAY REDEPLOY COMMAND - SOLUCIÓN

## **ERROR ACTUAL:**
```
/bin/bash: line 1: railway: command not found
RUN railway redeploy failed with exit code: 127
```

## **🔍 CAUSA:**
Una variable de entorno en Railway contiene el comando `railway redeploy` que no debería estar en el proceso de build.

## **🚨 VARIABLES PROBLEMÁTICAS (VERIFICAR EN RAILWAY):**

Probablemente una de estas variables contiene `railway redeploy`:
- `NIXPACKS_BUILD_CMD`
- `NIXPACKS_INSTALL_CMD`
- `NIXPACKS_START_CMD`

## **✅ CONFIGURACIÓN CORRECTA - VARIABLES RAILWAY:**

### **CAMBIAR/VERIFICAR estas variables en Railway Dashboard:**

```env
# ===== APLICACIÓN =====
APP_NAME="Power GYMA"
APP_ENV="production"
APP_KEY="base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs="
APP_URL="https://powergyma-app-web-production.up.railway.app"
ASSET_URL="https://powergyma-app-web-production.up.railway.app"
NODE_ENV="production"
FORCE_HTTPS="true"

# ===== NODE.JS (SOLUCIONA COLLISION) =====
NODE_VERSION="20.18.1"
NIXPACKS_NODE_VERSION="20"

# ===== NIXPACKS COMMANDS (SIN RAILWAY REDEPLOY) =====
NIXPACKS_INSTALL_CMD="composer install --no-dev --optimize-autoloader && npm install --include=dev"
NIXPACKS_BUILD_CMD="npm run build && php artisan storage:link"
NIXPACKS_START_CMD="php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=$PORT"

# ===== HTTPS =====
TRUST_PROXIES="*"

# ===== BASE DE DATOS =====
DB_CONNECTION="mysql"
DB_HOST="mysql.railway.internal"
DB_PORT="3306"
DB_DATABASE="railway"
DB_USERNAME="root"
DB_PASSWORD="XmAYhysjQKuqurqFzBLaACtbNeUCjWqf"
```

## **🔧 PASOS PARA SOLUCIONAR:**

### **1. Ve a Railway Dashboard:**
- https://railway.app/dashboard
- Proyecto PowerGYMA → Variables

### **2. BUSCAR y ELIMINAR cualquier variable que contenga:**
- `railway redeploy`
- `railway` (comando)

### **3. VERIFICAR estas variables específicamente:**
```env
NIXPACKS_BUILD_CMD=npm run build && php artisan storage:link
NIXPACKS_INSTALL_CMD=composer install --no-dev --optimize-autoloader && npm install --include=dev
NIXPACKS_START_CMD=php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=$PORT
```

### **4. ASEGURAR que NO hay:**
- Variables con `railway login`
- Variables con `railway redeploy`
- Variables con `railway deploy`

## **✅ RESULTADO ESPERADO:**
- ✅ Build sin errores de railway command
- ✅ Node.js 20.x sin collision
- ✅ Vite funcional para build
- ✅ HTTPS Mixed Content resuelto
- ✅ Aplicación completamente funcional

---
**El problema está en las variables de Railway, no en el código local.** 🚀
