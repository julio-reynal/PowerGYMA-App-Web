@echo off
echo Copiando archivos CSS y JS actualizados...

echo Copiando login.css...
copy "resources\css\login.css" "public\resources\css\login.css" /Y

echo Copiando login.js...
copy "resources\js\login.js" "public\resources\js\login.js" /Y

echo Limpiando cachés de Laravel...
php artisan cache:clear
php artisan view:clear
php artisan config:clear

echo ¡Archivos actualizados y cachés limpiadas!
pause