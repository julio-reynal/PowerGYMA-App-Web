# 🚀 CONFIGURACIÓN EXACTA PARA RAILWAY - POWER GYMA

## ✅ TU CONFIGURACIÓN ACTUAL (VERIFICADA)

### **Variables que están CORRECTAS:**
```bash
✅ APP_KEY=base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs=
✅ DB_CONNECTION=mysql
✅ DB_HOST=mysql.railway.internal
✅ DB_DATABASE=railway
✅ DB_USERNAME=root
✅ DB_PASSWORD=XkqwygNOdxJplpkRvVJpHGvHtpSCsaLH
✅ FORCE_HTTPS=true
✅ TRUST_PROXIES=*
✅ APP_URL=https://www.powergyma.com/
```

---

## ⚠️ CAMBIOS CRÍTICOS NECESARIOS

Ve a **Railway → Settings → Variables** y CAMBIA estas 2 variables:

### **1. SESSION_DRIVER**
```bash
Cambiar de:  SESSION_DRIVER=file
Cambiar a:   SESSION_DRIVER=database
```

**¿Por qué?** 
- En Railway, `file` no persiste entre reinicios
- `database` asegura que las sesiones se mantengan

### **2. CACHE_STORE**
```bash
Cambiar de:  CACHE_STORE=file
Cambiar a:   CACHE_STORE=database
```

**¿Por qué?**
- El cache en `file` se pierde en cada deployment
- `database` mantiene el cache persistente

---

## 🐛 PARA DEBUGGING TEMPORAL (OPCIONAL)

Si quieres ver el error exacto del 500, cambia temporalmente:

```bash
APP_DEBUG=true
LOG_LEVEL=debug
```

**⚠️ IMPORTANTE:** Después de ver el error, vuelve a poner:
```bash
APP_DEBUG=false
LOG_LEVEL=info
```

---

## 📋 CONFIGURACIÓN COMPLETA RECOMENDADA

Copia TODA esta configuración en Railway Variables:

```bash
# App
APP_NAME="Power GYMA"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs=
APP_URL=https://www.powergyma.com/
ASSET_URL=https://www.powergyma.com/
FORCE_HTTPS=true

# Locale
APP_LOCALE=es
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=es_PE

# Database
DB_CONNECTION=mysql
DB_HOST=mysql.railway.internal
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=XkqwygNOdxJplpkRvVJpHGvHtpSCsaLH
DB_PORT=3306

# Session & Cache (⚠️ CRÍTICO - CAMBIAR A DATABASE)
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
CACHE_STORE=database

# Storage
FILESYSTEM_DISK=local

# Queue
QUEUE_CONNECTION=database

# Mail
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@powergyma.com
MAIL_FROM_NAME="${APP_NAME}"

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=info

# Proxies
TRUST_PROXIES=*

# Vite
VITE_APP_NAME="${APP_NAME}"

# Node (ya configurado en nixpacks.toml)
NODE_VERSION=20.19.0
NODE_ENV=production
```

---

## 🚀 PASOS PARA APLICAR LOS CAMBIOS

### **1. Actualizar Variables en Railway**
1. Ve a Railway Dashboard
2. Selecciona tu servicio
3. Settings → Variables
4. Cambia `SESSION_DRIVER` a `database`
5. Cambia `CACHE_STORE` a `database`
6. Guarda cambios

### **2. Hacer Commit de los Cambios Locales**

```powershell
cd "c:\xampp\htdocs\Nueva carpeta\`$RSO45PZ\PowerGYMA-App-Web"

git add nixpacks.toml database/seeders/GeographicDataSeeder.php
git commit -m "Fix: Optimizar configuración Railway y corregir sesiones"
git push origin main
```

### **3. Railway Redesplegará Automáticamente**

Railway detectará el push y redesplegará con:
- ✅ Migraciones ejecutadas
- ✅ Departamentos y provincias cargadas
- ✅ Sesiones en base de datos
- ✅ Cache en base de datos

---

## 🔍 VERIFICAR EL DESPLIEGUE

### **En Railway Logs verás:**

```
Building...
✓ Composer install
✓ npm install
✓ npm run build
✓ Creating storage directories
✓ Setting permissions

Starting...
✓ Running migrations
✓ Seeding GeographicDataSeeder
  - 25 departamentos insertados
  - 196 provincias insertadas
✓ Caching config
✓ Caching routes
✓ Server started on port 8080
```

### **Visitando tu App:**

- ✅ https://www.powergyma.com/ debe cargar SIN error 500
- ✅ Las sesiones funcionarán correctamente
- ✅ Los departamentos y provincias estarán disponibles

---

## 🆘 SI PERSISTE EL ERROR 500

### **Revisar Logs en Railway:**

1. Dashboard → Tu servicio
2. Deployments → Último deployment
3. View Logs
4. Busca líneas rojas con "ERROR" o "Exception"

### **Activar Debug Temporal:**

Cambia en Railway Variables:
```bash
APP_DEBUG=true
LOG_LEVEL=debug
```

Luego visita la app para ver el error completo.

### **Errores Comunes:**

| Error | Solución |
|-------|----------|
| "Class GeographicDataSeeder not found" | Ejecutar `composer dump-autoload` en build |
| "Permission denied" | Verificar permisos de storage (ya en nixpacks) |
| "SQLSTATE[HY000]" | Verificar que MySQL esté corriendo |
| "Session driver not found" | Cambiar SESSION_DRIVER a database |

---

## ✅ CHECKLIST FINAL

- [ ] SESSION_DRIVER cambiado a `database` en Railway
- [ ] CACHE_STORE cambiado a `database` en Railway
- [ ] Commit y push realizados
- [ ] Railway redesplegando
- [ ] Logs verificados (sin errores)
- [ ] App accesible en https://www.powergyma.com/
- [ ] Sesiones funcionando
- [ ] Datos geográficos cargados

---

## 📊 VERIFICAR DATOS EN LA BASE DE DATOS

Después del despliegue, puedes verificar en Railway:

1. Railway Dashboard → MySQL service
2. Query (si está disponible)
3. Ejecutar:

```sql
-- Verificar departamentos
SELECT COUNT(*) as total FROM departamentos;
-- Debe mostrar: 25

-- Verificar provincias
SELECT COUNT(*) as total FROM provincias;
-- Debe mostrar: 196

-- Verificar Madre de Dios
SELECT p.* FROM provincias p 
JOIN departamentos d ON p.departamento_id = d.id 
WHERE d.nombre = 'Madre de Dios';
-- Debe mostrar: Tambopata, Manu, Tahuamanu
```

---

**¡Con estos cambios, el error 500 debería solucionarse!** 🎉
