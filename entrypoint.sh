#!/bin/sh
set -e

echo "🔧 Подготовка окружения Laravel..."

# # Создаём папки storage
# mkdir -p /app/storage/app/public
# mkdir -p /app/storage/framework/{cache,sessions,views}
# mkdir -p /app/storage/logs
# chmod -R 775 /app/storage
# chown -R www-data:www-data /app/storage

# # Симлинк public/storage → storage/app/public
# rm -rf /app/public/storage
# ln -s /app/storage/app/public /app/public/storage

# Кэшируем конфиги и маршруты
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Генерация ключа Laravel, если нет
php artisan key:generate || true

# Применяем миграции, если база доступна
php artisan migrate --force || true

echo "🚀 Запуск Laravel на порт ${PORT:-8000}..."
# Встроенный сервер PHP правильно слушает хост и порт Railway
exec php -S 0.0.0.0:${PORT:-8000} -t public
