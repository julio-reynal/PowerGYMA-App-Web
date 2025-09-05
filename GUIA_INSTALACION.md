# 📋 Guía de Instalación y Configuración - Proyecto Laravel "App-Web"

## 🎯 Resumen del Proyecto
- **Nombre del Proyecto:** App-Web
- **Framework:** Laravel 12.25.0
- **PHP Version:** 8.2.12
- **Composer Version:** 2.8.11
- **Ubicación:** `c:\xampp\htdocs\App-Web-Power-GYMA\App-Web`

---

## 📂 Estructura de Directorios

```
c:\xampp\htdocs\App-Web-Power-GYMA\
└── App-Web/                        # 🎯 Proyecto Laravel Principal
    ├── app/                        # Lógica de la aplicación
    │   ├── Http/Controllers/       # Controladores
    │   ├── Models/                 # Modelos Eloquent
    │   └── ...
    ├── bootstrap/                  # Archivos de arranque
    ├── config/                     # Configuraciones
    ├── database/                   # Base de datos
    │   ├── migrations/             # Migraciones
    │   ├── factories/              # Factories
    │   └── seeders/                # Seeders
    ├── public/                     # Punto de entrada web
    │   └── index.php               # Archivo principal
    ├── resources/                  # Recursos sin compilar
    │   ├── views/                  # Vistas Blade
    │   ├── css/                    # Estilos CSS
    │   └── js/                     # JavaScript
    ├── routes/                     # Definición de rutas
    │   ├── web.php                 # Rutas web
    │   └── api.php                 # Rutas API
    ├── storage/                    # Archivos generados
    ├── tests/                      # Tests automatizados
    ├── vendor/                     # Dependencias Composer
    ├── .env                        # Variables de entorno
    ├── artisan                     # CLI de Laravel
    ├── composer.json               # Dependencias PHP
    └── package.json                # Dependencias Node.js
```

---

## 🚀 Pasos de Instalación Ejecutados

### 1️⃣ Verificación de Requisitos
```bash
# Verificar versión de Composer
composer --version
# Resultado: Composer version 2.8.11, PHP version 8.2.12
```

### 2️⃣ Creación del Proyecto Laravel
```bash
# Navegar al directorio base
cd c:\xampp\htdocs\App-Web-Power-GYMA

# Crear proyecto Laravel
composer create-project laravel/laravel App-Web
```
**✅ Resultado:** 
- Laravel Framework 12.25.0 instalado
- 112 paquetes instalados automáticamente
- Clave de aplicación generada
- Base de datos SQLite creada
- Migraciones iniciales ejecutadas

### 3️⃣ Instalación de Dependencias Frontend
```bash
# Navegar al proyecto
cd c:\xampp\htdocs\App-Web-Power-GYMA\App-Web

# Instalar dependencias Node.js
npm install
```
**✅ Resultado:** 89 paquetes de Node.js instalados para desarrollo frontend

### 4️⃣ Verificación del Servidor
```bash
# Iniciar servidor de desarrollo
php artisan serve --host=127.0.0.1 --port=8000
```
**✅ Resultado:** Servidor ejecutándose en `http://127.0.0.1:8000`

---

## 🔧 Comandos para Desarrollo Diario

### 📍 Navegación al Proyecto
```bash
# Abrir terminal en la raíz del proyecto
cd "c:\xampp\htdocs\App-Web-Power-GYMA\App-Web"
```

### 🖥️ Iniciar Servidor de Desarrollo
```bash
# Opción 1: Servidor básico
php artisan serve

# Opción 2: Servidor con IP y puerto específicos
php artisan serve --host=127.0.0.1 --port=8000

# Opción 3: Servidor accesible desde red local
php artisan serve --host=0.0.0.0 --port=8000
```

### 🎨 Desarrollo Frontend
```bash
# Compilar assets en tiempo real (desarrollo)
npm run dev

# Compilar assets para producción
npm run build

# Modo watch (recarga automática)
npm run watch
```

### 🗄️ Comandos de Base de Datos
```bash
# Ejecutar migraciones
php artisan migrate

# Revertir migraciones
php artisan migrate:rollback

# Refrescar base de datos (⚠️ borra datos)
php artisan migrate:refresh

# Ejecutar seeders
php artisan db:seed
```

### 🛠️ Comandos Artisan Útiles
```bash
# Ver lista de comandos disponibles
php artisan list

# Crear controlador
php artisan make:controller NombreController

# Crear modelo
php artisan make:model NombreModelo

# Crear migración
php artisan make:migration create_tabla_name

# Crear middleware
php artisan make:middleware NombreMiddleware

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 🌐 URLs de Acceso

### 🏠 Aplicación Principal
- **Desarrollo:** `http://127.0.0.1:8000`
- **Red Local:** `http://[TU-IP-LOCAL]:8000`

### 📁 Archivos Importantes
- **Configuración Principal:** `c:\xampp\htdocs\App-Web-Power-GYMA\App-Web\.env`
- **Rutas Web:** `c:\xampp\htdocs\App-Web-Power-GYMA\App-Web\routes\web.php`
- **Controlador Principal:** `c:\xampp\htdocs\App-Web-Power-GYMA\App-Web\app\Http\Controllers\`

---

## 🔧 Configuración del Entorno

### Variables de Entorno (.env)
```bash
# Editar configuraciónDashboard de Administración
6
Total Usuarios
3
Administradores
1
Clientes
2
Usuarios Demo
0
Demos Expirados
Usuarios Recientes
Nombre	Email	Rol	Estado	Fecha de Registro
Admin Test	admin@test.com	Admin	Activo	27/08/2025
Usuario Demo Test	demo@test.com	Demo	Activo	26/08/2025
Admin Power GYMA	admin@powergyma.com	Admin	Activo	26/08/2025
Cliente Demo	cliente@powergyma.com	Cliente	Activo	26/08/2025
Entrenador Juan	entrenador@powergyma.com	Demo	Activo	26/08/2025
notepad .env

# Variables principales:
APP_NAME=App-Web
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# (Base de datos SQLite ya configurada)
```

### 🔐 Permisos de Carpetas (si es necesario)
```bash
# En caso de problemas de permisos
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

## 🚨 Resolución de Problemas Comunes

### ❌ Error: "Could not open input file: artisan"
**Solución:** Asegúrate de estar en el directorio correcto
```bash
cd "c:\xampp\htdocs\App-Web-Power-GYMA\App-Web"
```

### ❌ Error: Puerto 8000 ocupado
**Solución:** Usar otro puerto
```bash
php artisan serve --port=8001
```

### ❌ Error: Composer no encontrado
**Solución:** Verificar instalación de Composer
```bash
composer --version
```

### ❌ Error: npm no encontrado
**Solución:** Instalar Node.js desde [nodejs.org](https://nodejs.org)

---

## 📝 Próximos Pasos Recomendados

1. **🎨 Personalizar la vista principal**
   - Editar: `resources/views/welcome.blade.php`

2. **🛣️ Crear rutas personalizadas**
   - Editar: `routes/web.php`

3. **🎛️ Crear primer controlador**
   ```bash
   php artisan make:controller HomeController
   ```

4. **🗄️ Configurar base de datos (opcional)**
   - Editar configuración en `.env`

5. **🔐 Configurar autenticación (opcional)**
   ```bash
   php artisan make:auth
   ```

---

## 📞 Información de Soporte

- **Documentación Laravel:** [laravel.com/docs](https://laravel.com/docs)
- **Laravel Bootcamp:** [bootcamp.laravel.com](https://bootcamp.laravel.com)
- **Laracasts (Videos):** [laracasts.com](https://laracasts.com)

---

**🎉 ¡Tu proyecto Laravel "App-Web" está listo para desarrollar!**

*Fecha de creación: 25 de Agosto, 2025*
*Laravel Version: 12.25.0*
