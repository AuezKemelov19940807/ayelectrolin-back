FROM php:8.3-fpm

# === Устанавливаем зависимости ===
RUN apt-get update && apt-get install -y \
    unzip git libzip-dev libxml2-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libicu-dev libexif-dev curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo pdo_mysql mbstring bcmath exif intl gd \
    && docker-php-ext-enable exif intl gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# === Composer ===
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# === Рабочая директория ===
WORKDIR /app
COPY . .

# === Права для Laravel ===
RUN chown -R www-data:www-data /app && chmod -R 755 /app

# === GCS переменные ===
ENV GOOGLE_CLOUD_DISABLE_METADATA=true
# ENV GOOGLE_APPLICATION_CREDENTIALS=/app/storage/app/credentials/google-cloud.json

# === Composer без скриптов, потом package:discover ===
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction --no-scripts
RUN php artisan package:discover --ansi
RUN php artisan storage:link || true

# === Точка входа и CMD ===
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]
