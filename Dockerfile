FROM php:8.3-cli

# Устанавливаем зависимости и PHP-расширения
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

# Laravel зависимости
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction

# Filament ассеты
RUN php artisan filament:assets --ansi || true

# Генерация ключа (если нет)
RUN php artisan key:generate || true

# Кэш (config, routes, views)
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Storage symlink и копирование для Railway
RUN php artisan storage:link
RUN mkdir -p public/storage
RUN cp -r storage/app/public/* public/storage/ || true

# Копируем entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

# Используем entrypoint для старта контейнера
ENTRYPOINT ["/entrypoint.sh"]
