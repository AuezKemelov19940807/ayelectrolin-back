#!/bin/sh
set -e

echo "🔧 Подготовка Laravel с Google Cloud Storage..."

# Проверяем наличие переменных окружения
if [ -z "$GOOGLE_APPLICATION_CREDENTIALS" ]; then
  echo "❌ Ошибка: переменная GOOGLE_APPLICATION_CREDENTIALS не установлена!"
  exit 1
fi

if [ ! -f "$GOOGLE_APPLICATION_CREDENTIALS" ]; then
  echo "❌ Ошибка: файл ключа сервиса не найден по пути $GOOGLE_APPLICATION_CREDENTIALS"
  exit 1
fi

echo "✅ Ключ сервиса найден: $GOOGLE_APPLICATION_CREDENTIALS"

# Настройка Laravel
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Генерация ключа (если не установлен)
php artisan key:generate --force || true

# Миграции
php artisan migrate --force || true

echo "🚀 Запуск Laravel..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
