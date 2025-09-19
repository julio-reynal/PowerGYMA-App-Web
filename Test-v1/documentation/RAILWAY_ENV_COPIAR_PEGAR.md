# 📋 VARIABLES DE ENTORNO PARA RAILWAY - POWERGYMA

## 🚀 COPIAR Y PEGAR EN RAILWAY (Variables de Entorno)

```env
APP_NAME="Power GYMA"
APP_ENV="production"
APP_KEY="base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs="
APP_DEBUG="false"
APP_URL="https://powergyma-app-web-production.up.railway.app"
ASSET_URL="https://powergyma-app-web-production.up.railway.app"

# Node.js Configuration
NODE_ENV="production"
NODE_VERSION="20.19.0"

# Railway/Nixpacks Configuration
NIXPACKS_NODE_VERSION="20"

# Security & HTTPS
FORCE_HTTPS="true"
TRUST_PROXIES="*"

# Localization
APP_LOCALE="es"
APP_FALLBACK_LOCALE="en"
APP_FAKER_LOCALE="es_PE"

# Database (Railway MySQL)
DB_CONNECTION="mysql"
DB_HOST="mysql.railway.internal"
DB_PORT="3306"
DB_DATABASE="railway"
DB_USERNAME="root"
DB_PASSWORD="XmAYhysjQKuqurqFzBLaACtbNeUCjWqf"

# Sessions & Cache
SESSION_DRIVER="file"
SESSION_LIFETIME="120"
SESSION_ENCRYPT="false"
CACHE_STORE="file"
QUEUE_CONNECTION="database"

# Filesystem
FILESYSTEM_DISK="local"

# Logging
LOG_CHANNEL="stack"
LOG_LEVEL="info"

# Mail (usando log para desarrollo)
MAIL_MAILER="log"
MAIL_FROM_ADDRESS="noreply@powergyma.com"
MAIL_FROM_NAME="${APP_NAME}"

# Vite
VITE_APP_NAME="${APP_NAME}"
```

## 🔧 INSTRUCCIONES DE CONFIGURACIÓN:

### 1. **En Railway Dashboard:**
1. Ve a tu proyecto PowerGYMA
2. Ir a **Variables**
3. Copiar y pegar las variables de arriba UNA POR UNA

### 2. **Variables Críticas que DEBES verificar:**

```env
APP_URL="https://powergyma-app-web-production.up.railway.app"
ASSET_URL="https://powergyma-app-web-production.up.railway.app"
DB_PASSWORD="XmAYhysjQKuqurqFzBLaACtbNeUCjWqf"
```

### 3. **Generar nueva APP_KEY si es necesario:**
```bash
php artisan key:generate --show
```

### 4. **Verificar URL del proyecto:**
- Cambiar `powergyma-app-web-production.up.railway.app` por tu URL real de Railway

---

## ⚡ VARIABLES MÍNIMAS PARA FUNCIONAR:

Si quieres solo las **esenciales** para que funcione:

```env
APP_NAME="Power GYMA"
APP_ENV="production"
APP_KEY="base64:vAUG8BbJbiXaEuZYKBkM9suO0Q2j8cRwNi+/nTF2oMs="
APP_DEBUG="false"
APP_URL="https://powergyma-app-web-production.up.railway.app"
NODE_ENV="production"
NODE_VERSION="20.19.0"
DB_CONNECTION="mysql"
DB_HOST="mysql.railway.internal"
DB_PORT="3306"
DB_DATABASE="railway"
DB_USERNAME="root"
DB_PASSWORD="XmAYhysjQKuqurqFzBLaACtbNeUCjWqf"
FORCE_HTTPS="true"
APP_LOCALE="es"
```

**🎯 ¡Copia estas variables en Railway y tu aplicación debería funcionar perfectamente!**
