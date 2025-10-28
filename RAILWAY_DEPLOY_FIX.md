# 🚀 GUÍA DE DESPLIEGUE EN RAILWAY - POWER GYMA

## ⚠️ SOLUCIÓN AL ERROR 500

El error 500 generalmente se debe a:
1. ❌ Falta de APP_KEY
2. ❌ Base de datos no configurada
3. ❌ Variables de entorno incorrectas
4. ❌ Permisos de storage/cache

---

## 📋 PASOS PARA DESPLEGAR CORRECTAMENTE

### **1️⃣ AGREGAR SERVICIO MYSQL EN RAILWAY**

1. En tu proyecto de Railway, haz clic en **"+ New"**
2. Selecciona **"Database"** → **"Add MySQL"**
3. Railway creará automáticamente las variables:
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`

---

### **2️⃣ CONFIGURAR VARIABLES DE ENTORNO**

Ve a **Settings → Variables** y agrega estas variables:

#### **Variables Obligatorias:**

```bash
APP_NAME=Power GYMA
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs=
APP_URL=https://tu-app.up.railway.app
FORCE_HTTPS=true

# Database (Railway las provee automáticamente)
DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Logs
LOG_CHANNEL=stack
LOG_LEVEL=error
```

⚠️ **IMPORTANTE**: Si no tienes un `APP_KEY`, genera uno:
```bash
php artisan key:generate --show
```

---

### **3️⃣ CONFIGURACIÓN EN RAILWAY SETTINGS**

#### **Build Command:**
```bash
composer install --optimize-autoloader --no-dev
```

#### **Start Command (en nixpacks.toml):**
Ya está configurado en el archivo `nixpacks.toml`:
```bash
php artisan migrate --force && php artisan db:seed --class=GeographicDataSeeder --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

---

### **4️⃣ VERIFICAR PERMISOS (Si persiste el error)**

Si después de desplegar sigue el error 500, agrega esto al `nixpacks.toml` en la sección `[phases.build]`:

```toml
[phases.build]
cmds = [
  "npm install",
  "npm run build",
  "php artisan config:clear",
  "php artisan cache:clear",
  "mkdir -p storage/framework/sessions",
  "mkdir -p storage/framework/views",
  "mkdir -p storage/framework/cache",
  "chmod -R 775 storage bootstrap/cache"
]
```

---

### **5️⃣ VERIFICAR LOGS EN RAILWAY**

1. Ve a tu servicio en Railway
2. Haz clic en **"Deployments"**
3. Selecciona el deployment actual
4. Haz clic en **"View Logs"**
5. Busca errores específicos

---

## 🔍 ERRORES COMUNES Y SOLUCIONES

### **Error: "No application encryption key has been specified"**
✅ **Solución:** Agrega la variable `APP_KEY` en Railway

### **Error: "SQLSTATE[HY000] [2002] Connection refused"**
✅ **Solución:** Verifica que el servicio MySQL esté corriendo y las variables estén bien configuradas

### **Error: "failed to open stream: Permission denied"**
✅ **Solución:** Agrega permisos a storage (ver paso 4)

### **Error: "Class GeographicDataSeeder not found"**
✅ **Solución:** Ejecuta `composer dump-autoload` en build:
```toml
[phases.build]
cmds = [
  "npm install",
  "npm run build",
  "composer dump-autoload",
  "php artisan config:clear"
]
```

---

## 📊 VERIFICAR QUE TODO FUNCIONA

Después del despliegue, verifica:

1. ✅ La app carga sin error 500
2. ✅ Puedes acceder a la página principal
3. ✅ Los departamentos y provincias están en la BD

---

## 🆘 SI SIGUE EL ERROR 500

Agrega temporalmente `APP_DEBUG=true` en Railway para ver el error exacto:

1. Ve a Variables en Railway
2. Cambia `APP_DEBUG=false` a `APP_DEBUG=true`
3. Redespliega
4. Visita la página y verás el error detallado
5. **¡IMPORTANTE!** Vuelve a poner `APP_DEBUG=false` cuando termines

---

## 📞 CHECKLIST FINAL

- [ ] MySQL agregado en Railway
- [ ] Variables de entorno configuradas
- [ ] APP_KEY generada y configurada
- [ ] DB_* variables apuntando a MySQL
- [ ] nixpacks.toml simplificado
- [ ] Logs revisados en Railway
- [ ] App desplegada sin errores

---

## 🎯 COMANDO PARA DEBUG LOCAL

Para simular el entorno de producción localmente:

```bash
# 1. Copiar variables de Railway a .env
# 2. Ejecutar:
php artisan config:clear
php artisan cache:clear
php artisan migrate --force
php artisan db:seed --class=GeographicDataSeeder --force
php artisan serve
```

---

**¿Necesitas más ayuda?** Revisa los logs de Railway para el error específico.
