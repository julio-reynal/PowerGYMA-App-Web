# 🔐 Credenciales de Acceso - Power GYMA con Roles

## 🌐 URL de Acceso
- **Aplicación:** http://127.0.0.1:8000
- **Login:** http://127.0.0.1:8000/login

---

## 👥 **USUARIOS POR ROLES - CONTRASEÑAS ACTUALIZADAS**

### 🔧 **ADMINISTRADORES**
- **Admin Power GYMA**
  - Email: `admin@powergyma.com`
  - Contraseña: `admin123` ✅
  - Rol: Admin
  - Dashboard: `/admin/dashboard`

### 👤 **CLIENTES**
- **Cliente Power GYMA**
  - Email: `cliente@powergyma.com`
  - Contraseña: `cliente123` ✅
  - Rol: Cliente
  - Dashboard: `/cliente/dashboard`

### 🧪 **USUARIOS DEMO**
- **Usuario Demo Test**
  - Email: `test@example.com`
  - Contraseña: `password` ✅
  - Rol: Demo
  - Dashboard: `/demo/dashboard`

- **Entrenador** (Usuario adicional)
  - Email: `entrenador@powergyma.com`
  - Contraseña: `entrenador123` ✅
  - Rol: Cliente

---

## 🎯 **FUNCIONALIDADES POR ROL**

### 👑 **Administrador**
- ✅ Panel de administración completo
- ✅ Crear/editar/eliminar usuarios
- ✅ Crear usuarios demo con expiración
- ✅ Ver estadísticas del sistema
- ✅ Gestionar todos los aspectos

### 👤 **Cliente**
- ✅ Dashboard personal
- ✅ Acceso completo a funcionalidades del gimnasio
- ✅ Reservar clases
- ✅ Ver progreso personalizado

### 🧪 **Demo**
- ⚠️ Acceso limitado
- ✅ Ver instalaciones (solo lectura)
- ✅ Consultar planes ejemplo
- ❌ No puede reservar clases
- ❌ No acceso a entrenamientos personalizados
- ⏰ **Puede tener fecha de expiración**

---

## 🚀 **NAVEGACIÓN DEL SISTEMA**

### **Flujo de Login:**
1. Ir a http://127.0.0.1:8000/login
2. Introducir credenciales
3. **Redirección automática según rol:**
   - **Admin** → `/admin/dashboard`
   - **Cliente** → `/cliente/dashboard`
   - **Demo** → `/demo/dashboard`

### **Credenciales Verificadas y Funcionando:**

| **Usuario** | **Contraseña** | **Rol** | **Dashboard** |
|-------------|----------------|---------|---------------|
| `cliente@powergyma.com` | `cliente123` | Cliente | `/cliente/dashboard` |
| `admin@powergyma.com` | `admin123` | Admin | `/admin/dashboard` |
| `test@example.com` | `password` | Demo | `/demo/dashboard` |
| `entrenador@powergyma.com` | `entrenador123` | Cliente | Dashboard cliente |

### **Rutas Importantes:**
- **Admin Dashboard:** `/admin/dashboard`
- **Crear Usuario:** `/admin/users/create`
- **Crear Demo:** `/admin/demo/create`
- **Lista Usuarios:** `/admin/users`

---

## 🎉 **SISTEMA COMPLETAMENTE FUNCIONAL**

### ✅ **Implementado:**
- Sistema de roles completo (Admin/Cliente/Demo)
- Dashboards diferenciados por rol
- Control de expiración para usuarios demo
- Panel de administración funcional
- Middleware de seguridad
- Verificaciones automáticas de estado y expiración

### 🔄 **Funcionalidades de Admin:**
- Ver estadísticas del sistema
- Crear usuarios de cualquier rol
- Crear usuarios demo con fecha de expiración
- Gestionar estado activo/inactivo de usuarios

---

**Fecha:** 28 de Agosto, 2025  
**Estado:** ✅ Sistema de login completamente funcional y verificado  
**Servidor:** ✅ Ejecutándose en http://127.0.0.1:8000
