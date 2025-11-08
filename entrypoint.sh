#!/bin/sh
set -e

echo "Ждём базу и запускаем миграции..."
php artisan migrate --force

echo "Создаём или обновляем администратора..."
php artisan tinker --execute "\
\$user = App\Models\User::firstOrNew(['email' => 'admin@railway.app']); \
\$user->name = 'Railway Admin'; \
\$user->is_admin = 1; \
\$user->email_verified_at = now(); \
\$user->password = bcrypt('admin123'); \
\$user->save();"

echo "Очищаем кэш и готовим всё к работе..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Запускаем сервер Laravel..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
