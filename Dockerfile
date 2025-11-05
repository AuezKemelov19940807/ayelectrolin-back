FROM php:8.3-cli

# Зависимости и PHP-расширения
RUN apt-get update && apt-get install -y \
    unzip git libzip-dev libxml2-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev libicu-dev libexif-dev curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install zip pdo pdo_mysql mbstring bcmath exif intl \
    && docker-php-ext-enable exif intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .

# Права
RUN chown -R www-data:www-data /app

# Laravel
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction

# Filament
RUN php artisan filament:assets --ansi

# Storage link
RUN php artisan storage:link

# Генерация ключа
RUN php artisan key:generate || true

# Копируем entrypoint
COPY docker-entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

# Запуск через entrypoint
ENTRYPOINT ["/entrypoint.sh"]
