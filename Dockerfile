FROM php:8.3-fpm

# ==== Системные зависимости ====
RUN apt-get update && apt-get install -y \
    unzip git libzip-dev libxml2-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libicu-dev libexif-dev curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo pdo_mysql mbstring bcmath exif intl gd \
    && docker-php-ext-enable exif intl gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ==== Composer ====
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# Копируем проект
COPY . .

# Права
RUN chown -R www-data:www-data /app && chmod -R 755 /app

# Устанавливаем зависимости PHP (важно: БЕЗ скриптов)
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction --no-scripts

# ==== Точка входа ====
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]
