# 🚨 Solución de Problemas - Railway Deployment

## Problema: Assets (CSS/JS) no cargan

### ✅ Solución:

1. **Verificar variables en Railway:**
```bash
APP_URL=https://tu-dominio.railway.app
ASSET_URL=https://tu-dominio.railway.app
VITE_BASE_URL=https://tu-dominio.railway.app
```

2. **Comando actualizado de build:**
```bash
NIXPACKS_BUILD_CMD=composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link && php artisan optimize
```

3. **Verificar assets:**
```bash
railway run ls -la public/build/
railway run cat public/build/manifest.json
```

## Problema: Rutas no funcionan (404 errors)

### ✅ Solución:

1. **Verificar .htaccess:**
```bash
railway run cat public/.htaccess
```

2. **Limpiar caché de rutas:**
```bash
railway run php artisan route:clear
railway run php artisan route:cache
railway run php artisan config:cache
```

3. **Verificar configuración de URL:**
```bash
railway run php artisan config:show app.url
```

## Problema: Página en blanco o Error 500

### ✅ Solución:

1. **Ver logs detallados:**
```bash
railway logs --tail
```

2. **Verificar permisos:**
```bash
railway run php artisan storage:link
railway run chmod -R 755 storage bootstrap/cache
```

3. **Limpiar todos los cachés:**
```bash
railway run php artisan optimize:clear
railway run php artisan config:cache
```

## Comandos de Emergencia

### Reset completo:
```bash
railway run php artisan optimize:clear
railway run php artisan config:cache
railway run php artisan route:cache
railway run php artisan view:cache
railway redeploy
```

### Verificar estado:
```bash
railway run php artisan about
railway run php artisan config:show
railway run php artisan route:list
```

### Verificar base de datos:
```bash
railway run php artisan migrate:status
railway run php artisan tinker
# En tinker: DB::connection()->getPdo();
```

## Checklist de Verificación

- [ ] APP_URL configurada correctamente
- [ ] NIXPACKS_BUILD_CMD actualizada
- [ ] Assets compilados en public/build/
- [ ] .htaccess existe en public/
- [ ] Rutas cacheadas correctamente
- [ ] Base de datos conectada
- [ ] Logs sin errores críticos

## URLs para verificar manualmente:

1. `https://tu-app.railway.app/` - Página principal
2. `https://tu-app.railway.app/login` - Login
3. `https://tu-app.railway.app/build/assets/app-xxx.css` - Assets CSS
4. `https://tu-app.railway.app/build/assets/app-xxx.js` - Assets JS
