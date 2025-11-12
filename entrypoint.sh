#!/bin/sh
set -e

echo "🔧 Подготовка окружения Laravel..."

# Создаём нужные директории
mkdir -p /app/storage/app/public
mkdir -p /app/storage/framework/{cache,sessions,views}
mkdir -p /app/storage/logs
chmod -R 775 /app/storage
chown -R www-data:www-data /app/storage

# Символическая ссылка storage
if [ ! -L /app/public/storage ]; then
    echo "🔗 Создаём символическую ссылку public/storage..."
    rm -rf /app/public/storage
    ln -s /app/storage/app/public /app/public/storage
fi

# Очистка и кэширование
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Генерация ключа Laravel
php artisan key:generate || true

# Применяем миграции
php artisan migrate --force || true

echo "🚀 Запуск Laravel..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
