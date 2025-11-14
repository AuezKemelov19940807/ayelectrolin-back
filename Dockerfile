# -----------------------------
# Базовый образ
# -----------------------------
FROM php:8.3-cli

# -----------------------------
# Устанавливаем зависимости PHP
# -----------------------------
RUN apt-get update && apt-get install -y \
    unzip git libzip-dev libxml2-dev libonig-dev curl \
    libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev \
    && docker-php-ext-install zip pdo pdo_mysql gd

# -----------------------------
# Устанавливаем Composer
# -----------------------------
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# -----------------------------
# Копируем проект
# -----------------------------
WORKDIR /var/www/html
COPY . .

# -----------------------------
# Отключаем обращение к GCP metadata
# -----------------------------
ENV GOOGLE_CLOUD_DISABLE_METADATA=true

# -----------------------------
# Устанавливаем зависимости без dev и без скриптов, чтобы избежать ошибок GCS
# -----------------------------
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction --no-scripts

# -----------------------------
# Копируем entrypoint и даем права
# -----------------------------
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# -----------------------------
# Настройка рабочей директории
# -----------------------------
RUN php artisan storage:link || true
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# -----------------------------
# Старт контейнера
# -----------------------------
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]
