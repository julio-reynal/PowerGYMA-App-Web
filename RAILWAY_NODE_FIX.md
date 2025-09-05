# 🚨 SOLUCIÓN ERROR NODE.JS COLLISION - RAILWAY

## **ERROR ACTUAL:**
```
error: collision between nodejs-18.20.5 and nodejs-20.18.1
```

## **🔧 SOLUCIÓN APLICADA:**

### **1. Archivo `.nvmrc` creado:**
- Fuerza Node.js versión 20

### **2. `package.json` actualizado:**
- Agregado `engines.node: "20.x"`
- Railway respetará esta configuración

### **3. Variables Railway REQUERIDAS:**
```env
NODE_VERSION=20.18.1
NIXPACKS_NODE_VERSION=20
NODE_ENV=production
```

## **🚀 PASOS PARA IMPLEMENTAR:**

### **1. Ve a Railway Dashboard:**
- https://railway.app/dashboard
- Selecciona tu proyecto PowerGYMA

### **2. Variables → Agregar estas:**
```
NODE_VERSION=20.18.1
NIXPACKS_NODE_VERSION=20
```

### **3. Variables existentes - verificar:**
```
APP_URL=https://powergyma-app-web-production.up.railway.app
ASSET_URL=https://powergyma-app-web-production.up.railway.app
APP_ENV=production
NODE_ENV=production
FORCE_HTTPS=true
```

### **4. Redeploy:**
- Los cambios se subirán automáticamente
- Railway usará solo Node.js 20.x
- No más conflictos de versiones

## **🎯 RESULTADO ESPERADO:**
- ✅ Build exitoso con Node.js 20.x únicamente
- ✅ Sin collision errors
- ✅ Aplicación funcionando con HTTPS assets

---
**NOTA:** Este error es común cuando Railway detecta múltiples versiones de Node.js. La solución fuerza una sola versión específica.
