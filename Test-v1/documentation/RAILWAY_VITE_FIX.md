# 🚨 SOLUCIÓN ERROR "vite: not found" - RAILWAY

## **ERROR ACTUAL:**
```
sh: 1: vite: not found
npm run build failed with exit code: 127
```

## **🔍 CAUSA:**
- `vite` estaba en `devDependencies`
- Railway ejecuta `npm ci` que no instala devDependencies en producción
- El comando `vite build` no encuentra el ejecutable

## **🔧 SOLUCIÓN APLICADA:**

### **1. package.json actualizado:**
```json
{
  "dependencies": {
    "vite": "^7.0.4",
    "laravel-vite-plugin": "^2.0.0"
  },
  "scripts": {
    "build": "vite build",
    "production": "vite build",
    "postinstall": "vite build"
  }
}
```

### **2. nixpacks.toml actualizado:**
```toml
[variables]
NODE_VERSION = "20"

[phases.install]
cmds = [
  "composer install --no-dev --optimize-autoloader",
  "npm install --include=dev"
]

[phases.build]
cmds = [
  "npm run build",
  "php artisan storage:link"
]
```

## **✅ CAMBIOS CLAVE:**

1. **Vite movido a dependencies** → Disponible en producción
2. **npm install --include=dev** → Instala devDependencies necesarias
3. **Node.js 20** → Versión consistente
4. **Scripts adicionales** → Fallbacks para build

## **🚀 VARIABLES RAILWAY REQUERIDAS:**
```env
NODE_VERSION=20.18.1
NIXPACKS_NODE_VERSION=20
NODE_ENV=production
APP_ENV=production
```

## **🎯 RESULTADO ESPERADO:**
- ✅ `vite` disponible durante build
- ✅ `npm run build` ejecuta correctamente
- ✅ Assets compilados con éxito
- ✅ Aplicación desplegada sin errores

---
**NOTA:** Este es un problema común en deployments donde las herramientas de build están en devDependencies pero se necesitan en producción.
