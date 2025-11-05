#!/bin/sh
set -e

# Ждём доступности базы (опционально)
# пока база не откроется на хосте и порту
# можно использовать утилиту wait-for-it.sh или простой цикл

# Миграции и кэш
php artisan migrate --force
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Запуск сервера
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}