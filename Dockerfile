FROM php:8.3-cli

# Устанавливаем зависимости и PHP-расширения
RUN apt-get update && apt-get install -y \
    unzip git libzip-dev libxml2-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev libicu-dev libexif-dev curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install zip pdo pdo_mysql mbstring bcmath exif intl \
    && docker-php-ext-enable exif intl

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .

RUN chown -R www-data:www-data /app
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction
RUN php artisan key:generate || true

EXPOSE 8000

# Запуск Laravel сервера без миграций
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
