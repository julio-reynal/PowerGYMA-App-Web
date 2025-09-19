# 🚀 CONFIGURACIÓN COMPLETA RAILWAY - POWER GYMA

## **✅ VARIABLES ACTUALES (YA CONFIGURADAS):**
```env
APP_NAME="Power GYMA"
APP_ENV="production"
APP_KEY="base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs="
APP_DEBUG="true"
APP_URL="https://powergyma-app-web-production.up.railway.app"
ASSET_URL="https://powergyma-app-web-production.up.railway.app"
NODE_ENV="production"
FORCE_HTTPS="true"
# ... (resto de variables ya configuradas)
```

## **🚨 VARIABLES FALTANTES (AGREGAR ESTAS):**
```env
NODE_VERSION=20.18.1
NIXPACKS_NODE_VERSION=20
```

## **🔧 VARIABLE A MODIFICAR:**
```env
# CAMBIAR:
NIXPACKS_BUILD_CMD=composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan storage:link

# POR:
NIXPACKS_BUILD_CMD=composer install --no-dev --optimize-autoloader && npm install --include=dev && npm run build && php artisan storage:link
```

## **🎯 PASOS PARA IMPLEMENTAR:**

### **1. Ve a Railway Dashboard:**
- https://railway.app/dashboard
- Proyecto PowerGYMA → Variables

### **2. AGREGAR estas variables:**
- `NODE_VERSION` = `20.18.1`
- `NIXPACKS_NODE_VERSION` = `20`

### **3. MODIFICAR esta variable:**
- `NIXPACKS_BUILD_CMD` = `composer install --no-dev --optimize-autoloader && npm install --include=dev && npm run build && php artisan storage:link`

## **✅ RESULTADO ESPERADO:**
- ✅ Node.js 20.x únicamente (sin collision)
- ✅ vite disponible durante build
- ✅ devDependencies instaladas para build
- ✅ Assets CSS/JS compilados correctamente
- ✅ HTTPS funcionando
- ✅ Aplicación totalmente funcional

## **📋 VERIFICACIÓN POST-DEPLOY:**
1. Visitar: https://powergyma-app-web-production.up.railway.app
2. Verificar en DevTools (F12) que no hay errores Mixed Content
3. Confirmar que CSS y JS cargan correctamente
4. Verificar funcionalidad completa

---
**Con estos 3 cambios, todos los errores deberían estar resueltos.** 🚀
