@echo off
echo Reseteando base de datos y migraciones...
echo.

echo 1. Eliminando todas las tablas...
php artisan migrate:reset

echo.
echo 2. Ejecutando migraciones desde 0...
php artisan migrate

echo.
echo 3. Ejecutando seeders...
php artisan db:seed

echo.
echo ¡Proceso completado!
pause
