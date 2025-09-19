# ✅ CHECKLIST LIMPIEZA RAILWAY DASHBOARD

## **PASOS EXACTOS PARA SOLUCIONAR:**

### **PASO 1: Abrir Railway Dashboard**
1. Ve a: https://railway.app/dashboard
2. Clic en proyecto **PowerGYMA-App-Web**
3. Clic en **Variables** (en el sidebar)

### **PASO 2: BUSCAR Y ELIMINAR variables problemáticas**

**Buscar estas variables y ELIMINARLAS completamente:**
- [ ] `BUILD_CMD` (si existe)
- [ ] `INSTALL_CMD` (si existe) 
- [ ] `START_CMD` (si existe)
- [ ] Cualquier variable que contenga "railway redeploy"
- [ ] Cualquier variable que contenga "railway deploy"
- [ ] Variables duplicadas o de prueba

### **PASO 3: VERIFICAR variables NIXPACKS**

**NIXPACKS_BUILD_CMD debe ser EXACTAMENTE:**
```
npm run build && php artisan storage:link
```

**NIXPACKS_INSTALL_CMD debe ser EXACTAMENTE:**
```
composer install --no-dev --optimize-autoloader && npm install --include=dev
```

**NIXPACKS_START_CMD debe ser EXACTAMENTE:**
```
php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

### **PASO 4: AGREGAR variables faltantes**
- [ ] `NODE_VERSION` = `20.18.1`
- [ ] `NIXPACKS_NODE_VERSION` = `20`
- [ ] `FORCE_HTTPS` = `true`
- [ ] `TRUST_PROXIES` = `*`

### **PASO 5: VERIFICAR configuración final**

**Variables CORE (deben existir):**
- [ ] `APP_NAME` = `Power GYMA`
- [ ] `APP_ENV` = `production`
- [ ] `APP_URL` = `https://powergyma-app-web-production.up.railway.app`
- [ ] `DB_CONNECTION` = `mysql`
- [ ] `DB_HOST` = `mysql.railway.internal`

## **🚨 IMPORTANTE:**
- NO debe haber NINGUNA variable que contenga comandos "railway"
- Solo usar comandos de build estándar (npm, php, composer)
- Las variables NIXPACKS solo deben contener comandos de aplicación

## **✅ TRAS COMPLETAR:**
Railway redesplegará automáticamente y el error debería desaparecer.

---
**Completa cada checkbox ✅ en Railway Dashboard**
