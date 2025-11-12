# Dockerfile для Laravel 10/12 на PHP 8.3 CLI
FROM php:8.3-cli

# Устанавливаем системные зависимости и PHP-расширения
RUN apt-get update && apt-get install -y \
    unzip git libzip-dev libxml2-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libicu-dev libexif-dev curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install zip pdo pdo_mysql mbstring bcmath exif intl \
    && docker-php-ext-enable exif intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Рабочая директория
WORKDIR /app

# Копируем проект
COPY . .

# Права
RUN chown -R www-data:www-data /app && chmod -R 755 /app

# Устанавливаем все зависимости (включая GCS-драйвер, уже добавленный в composer.json)
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction

# Копируем entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Порт для Laravel
EXPOSE 8000

# Railway запускает ENTRYPOINT с переменной $PORT
ENTRYPOINT ["/entrypoint.sh"]
