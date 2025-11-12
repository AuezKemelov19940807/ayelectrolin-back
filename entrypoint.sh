#!/bin/sh
set -e

echo "🔧 Подготовка окружения Laravel..."

# ВОССТАНАВЛИВАЕМ storage после монтирования
mkdir -p /app/storage/app/public
mkdir -p /app/storage/framework/cache
mkdir -p /app/storage/framework/sessions
mkdir -p /app/storage/framework/views
mkdir -p /app/storage/logs
chmod -R 775 /app/storage
chown -R www-data:www-data /app/storage

# Выводим содержимое volume для проверки
echo "📂 Проверка содержимого volume..."
ls -la /app/storage || true
ls -la /app/storage/framework || true
ls -la /app/storage/app/public || true
echo "✅ Проверка volume завершена."

# Симлинк public/storage → storage/app/public
if [ ! -L /app/public/storage ]; then
    echo "🔗 Создаём символическую ссылку public/storage..."
    rm -rf /app/public/storage
    ln -s /app/storage/app/public /app/public/storage
fi

# Проверим кеш путь (на всякий случай)
if [ ! -d /app/storage/framework/views ]; then
    mkdir -p /app/storage/framework/views
fi

# Очистка и кэширование конфигов и маршрутов
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Генерация ключа Laravel
php artisan key:generate || true

# Применяем миграции (если база доступна)
php artisan migrate --force || true

echo "🚀 Запуск Laravel..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
