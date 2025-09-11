# Solución para ViteManifestNotFoundException

## Problema
Laravel no puede encontrar el archivo `manifest.json` de Vite en la ubicación esperada:
```
Illuminate\Foundation\ViteManifestNotFoundException
Vite manifest not found at: C:\xampp\htdocs\Nueva carpeta\$RSO45PZ\PowerGYMA-App-Web\public\build/manifest.json
```

## Causa
Vite está generando el archivo `manifest.json` en `public/build/.vite/manifest.json` pero Laravel lo busca en `public/build/manifest.json`.

## Solución Implementada

### 1. Script automático en package.json
Se agregó un script que mueve automáticamente el manifest después del build:

```json
{
  "scripts": {
    "build": "vite build && npm run fix-manifest",
    "fix-manifest": "powershell -Command \"if (Test-Path 'public/build/.vite/manifest.json') { Move-Item 'public/build/.vite/manifest.json' 'public/build/manifest.json' -Force }\""
  }
}
```

### 2. Comando manual (si es necesario)
Si necesitas corregir manualmente:

```powershell
Move-Item "public/build/.vite/manifest.json" "public/build/manifest.json" -Force
```

### 3. Verificación
Para verificar que funciona:

1. Ejecuta `npm run build`
2. Verifica que existe `public/build/manifest.json`
3. Inicia el servidor con `php artisan serve`
4. Visita `http://127.0.0.1:8000`

## Estado Actual
✅ **RESUELTO** - El servidor está funcionando correctamente en `http://127.0.0.1:8000`

## Archivos Modificados
- `package.json` - Agregado script fix-manifest
- `vite.config.js` - Configuración simplificada
- `public/build/manifest.json` - Movido a ubicación correcta

## Comandos para desarrollo
```bash
# Desarrollo (con hot reload)
npm run dev

# Producción (con fix automático)
npm run build
```
