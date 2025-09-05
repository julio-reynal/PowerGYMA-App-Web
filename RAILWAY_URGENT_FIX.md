# 🚨 VARIABLES PROBLEMÁTICAS EN RAILWAY - ELIMINAR AHORA

## **BUSCAR Y ELIMINAR ESTAS VARIABLES:**

### **Variables que probablemente contienen "railway redeploy":**
- `NIXPACKS_BUILD_CMD`
- `NIXPACKS_INSTALL_CMD` 
- `NIXPACKS_START_CMD`
- `BUILD_CMD`
- `INSTALL_CMD`
- `START_CMD`
- Cualquier variable personalizada que hayas creado

## **🔍 PASOS PARA ENCONTRAR LA VARIABLE PROBLEMÁTICA:**

### **1. Ve a Railway Dashboard:**
- https://railway.app/dashboard
- Proyecto PowerGYMA → **Variables**

### **2. BUSCAR en cada variable el texto:**
- `railway redeploy`
- `railway deploy`
- `railway`

### **3. ELIMINAR completamente esas variables**

### **4. AGREGAR solo estas variables limpias:**

```env
NODE_VERSION=20.18.1
NIXPACKS_NODE_VERSION=20
NIXPACKS_BUILD_CMD=npm run build && php artisan storage:link
FORCE_HTTPS=true
TRUST_PROXIES=*
```

## **⚠️ VARIABLES A ELIMINAR SI EXISTEN:**
- Cualquier variable que contenga `railway redeploy`
- Variables que contengan comandos CLI de Railway
- Variables duplicadas o de prueba

## **✅ VARIABLES PERMITIDAS (SOLO ESTAS):**
```
APP_NAME=Power GYMA
APP_ENV=production
APP_KEY=base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs=
APP_DEBUG=true
APP_URL=https://powergyma-app-web-production.up.railway.app
ASSET_URL=https://powergyma-app-web-production.up.railway.app
NODE_VERSION=20.18.1
NODE_ENV=production
NIXPACKS_NODE_VERSION=20
NIXPACKS_BUILD_CMD=npm run build && php artisan storage:link
FORCE_HTTPS=true
TRUST_PROXIES=*
DB_CONNECTION=mysql
DB_HOST=mysql.railway.internal
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=XmAYhysjQKuqurqFzBLaACtbNeUCjWqf
```

---
**URGENTE: Elimina TODAS las variables que contengan comandos "railway" del Dashboard.** 🚨
