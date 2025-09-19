# 🔐 Credenciales de Acceso - Power GYMA

## 🌐 URL de Acceso
- **Aplicación:** http://127.0.0.1:8000
- **Login:** http://127.0.0.1:8000/login

---

## �️ **Base de Datos: MySQL**
- **Base de Datos:** `power_gyma`
- **Host:** `127.0.0.1:3306`
- **Usuario DB:** `root` (sin contraseña)
- **Motor:** MySQL/MariaDB via XAMPP

---

## �👥 Usuarios Disponibles

### 🔧 **Administrador Original**
- **Email:** `admin@example.com`
- **Contraseña:** `password`
- **Nombre:** Admin

### � **Administrador Power GYMA**
- **Email:** `admin@powergyma.com`
- **Contraseña:** `password123`
- **Nombre:** Admin Power GYMA

### � **Cliente Demo**
- **Email:** `cliente@powergyma.com`
- **Contraseña:** `password123`
- **Nombre:** Cliente Demo

### 💪 **Entrenador**
- **Email:** `entrenador@powergyma.com`
- **Contraseña:** `password123`
- **Nombre:** Entrenador Juan

---

## 🚀 Instrucciones de Uso

1. **Verificar que MySQL esté corriendo en XAMPP**
   - Abrir XAMPP Control Panel
   - Iniciar Apache y MySQL

2. **Iniciar el servidor Laravel:**
   ```bash
   cd "c:\xampp\htdocs\App-Web-Power-GYMA\App-Web"
   php artisan serve
   ```

3. **Acceder a la aplicación:**
   - Ir a: http://127.0.0.1:8000
   - Hacer clic en "Acceso Clientes"
   - Usar cualquiera de las credenciales de arriba

4. **Agregar nuevos usuarios (via MySQL):**
   ```sql
   USE power_gyma;
   INSERT INTO users (name, email, password, created_at, updated_at) 
   VALUES ('Nuevo Usuario', 'nuevo@powergyma.com', '$2y$12$LQv3c1yqBwRF6G.VQ9bl9usLxkvTI3Tj9Suw6v7e1w7QxV3IcDQIG', NOW(), NOW());
   ```

---

## 🛠️ **Comandos Útiles**

### **Acceso a MySQL via XAMPP:**
```bash
cd "c:\xampp\mysql\bin"
.\mysql.exe -u root
```

### **Verificar usuarios desde Laravel:**
```bash
php artisan tinker --execute="echo App\Models\User::count();"
```

### **Limpiar cachés:**
```bash
php artisan config:clear
php artisan cache:clear
```

---

## ⚠️ Notas Importantes

- **Base de datos:** Ahora usa MySQL en lugar de SQLite
- **Configuración:** Archivo `.env` actualizado para MySQL
- **XAMPP:** Asegúrate de que MySQL esté corriendo
- **Charset:** UTF8MB4 para soporte completo de caracteres
- **Usuarios:** Todos con contraseña `password123` excepto admin original

---

## 📊 **Estado Actual**
- ✅ Base de datos MySQL configurada
- ✅ Tabla `users` creada 
- ✅ 4 usuarios de prueba disponibles
- ✅ Laravel conectado a MySQL
- ✅ Servidor corriendo en http://127.0.0.1:8000

---

**Fecha de actualización:** 26 de Agosto, 2025  
**Base de datos:** MySQL (power_gyma)  
**Estado:** ✅ Funcionando con MySQL
