#!/bin/sh
set -e

# Ждём базу (опционально)
# Можно добавить wait-for-it.sh или свой цикл, если нужно

echo "Запускаем миграции и кэш Laravel..."

php artisan migrate --force


php artisan tinker --execute "\
App\Models\User::create([
    'name' => 'New Admin',
    'email' => 'ayelectrolin@demo.com',
    'password' => bcrypt('admin123'),
    'is_admin' => true \
]);"

php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Файлы storage → public
php artisan storage:link || true
mkdir -p public/storage
cp -r storage/app/public/* public/storage/ || true

echo "Запуск Laravel сервера..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
