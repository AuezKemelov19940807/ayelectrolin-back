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

echo "Принудительно задаём HTTPS, если X-Forwarded-Proto=https"
php artisan tinker --execute "\
if (request()->header('X-Forwarded-Proto') === 'https') { \
    \Illuminate\Support\Facades\URL::forceScheme('https'); \
    \Log::info('Force HTTPS: X-Forwarded-Proto detected'); \
} else { \
    \Log::info('Scheme detected: '.request()->getScheme()); \
}"

echo "Запускаем сервер Laravel..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
