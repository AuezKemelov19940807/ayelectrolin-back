# Используем PHP 8.3, т.к. Filament и Spatie требуют >= 8.3
FROM php:8.3-cli

# Устанавливаем зависимости и PHP-расширения
RUN apt-get update && apt-get install -y \
    unzip git libzip-dev libxml2-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev libicu-dev libexif-dev curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install zip pdo pdo_mysql mbstring bcmath exif intl \
    && docker-php-ext-enable exif intl

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Рабочая директория
WORKDIR /app
COPY . .

# Права для www-data
RUN chown -R www-data:www-data /app

# Устанавливаем зависимости Laravel
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction

# Генерация ключа (если .env существует)
RUN php artisan key:generate || true

# Открываем порт
EXPOSE 8000

# Запуск Laravel сервера
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
