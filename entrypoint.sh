#!/bin/sh
set -e

echo "🔧 Подготовка окружения Laravel..."

# Проверка/создание нужных папок в storage
mkdir -p /app/storage/app/public
mkdir -p /app/storage/framework/{cache,sessions,views}
mkdir -p /app/storage/logs
chmod -R 775 /app/storage
chown -R www-data:www-data /app/storage

# Симлинк public/storage → storage/app/public
if [ ! -L /app/public/storage ]; then
    echo "🔗 Создаём символическую ссылку public/storage..."
    rm -rf /app/public/storage
    ln -s /app/storage/app/public /app/public/storage
fi

# Кэшируем конфиги и маршруты
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Применяем миграции (если база доступна)
php artisan migrate --force || true

echo "🚀 Запуск Laravel..."
exec php artisan serve --host=0.0.0.0 --port=8000
