#!/bin/sh
set -e

echo "Ждём базу и запускаем миграции..."
php artisan migrate --force

echo "Создаём нового администратора, если его нет..."
php artisan tinker --execute "\
if (!App\Models\User::where('email', 'admin@railway.app')->exists()) {
    App\Models\User::create([
        'name' => 'Railway Admin',
        'email' => 'admin@railway.app',
        'password' => bcrypt('admin123'),
        'is_admin' => 1
    ]);
}"

echo "Очищаем кэш и готовим всё к работе..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Запускаем сервер Laravel..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
