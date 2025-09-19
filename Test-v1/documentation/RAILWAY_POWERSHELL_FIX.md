# Fix para Error de PowerShell en Railway

## Problema
El error ocurre porque el script `fix-manifest` en `package.json` usa PowerShell, que no está disponible en los contenedores Linux de Railway.

## Solución Aplicada

### 1. Corregir package.json
Se cambió el script `fix-manifest` de:
```json
"fix-manifest": "powershell -Command \"if (Test-Path 'public/build/.vite/manifest.json') { Move-Item 'public/build/.vite/manifest.json' 'public/build/manifest.json' -Force }\""
```

A:
```json
"fix-manifest": "test -f 'public/build/.vite/manifest.json' && mv 'public/build/.vite/manifest.json' 'public/build/manifest.json' || echo 'Manifest file not found or already moved'"
```

### 2. Mejorar build.sh
- Se agregó un script `build-only` que solo ejecuta Vite sin el fix-manifest
- Se implementó el fix de manifest manualmente en el script bash
- Se mantuvieron las estrategias de fallback

### 3. Script de Emergencia
Se creó `build-simple.sh` como alternativa en caso de que el build principal falle.

## Scripts Disponibles
- `npm run build` - Build completo con fix de manifest
- `npm run build-only` - Solo build de Vite
- `./build.sh` - Script personalizado con múltiples estrategias
- `./build-simple.sh` - Script simple para emergencias

## Deployment en Railway
El proyecto ahora debería deployar correctamente en Railway sin errores de PowerShell.

Si hay problemas, verificar:
1. Que los scripts tengan permisos de ejecución
2. Que las variables de entorno estén configuradas
3. Que los archivos de manifest se generen correctamente

## Testing Local
Para probar localmente que funciona:
```bash
# En Windows (local)
npm run build

# Simular entorno Linux
bash ./build-simple.sh
```
