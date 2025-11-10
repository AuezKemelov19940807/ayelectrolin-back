# Dockerfile для Laravel 10 на PHP 8.3 CLI
FROM php:8.3-cli

# Установка системных зависимостей и PHP-расширений
RUN apt-get update && apt-get install -y \
    unzip git libzip-dev libxml2-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libicu-dev libexif-dev curl \
    && docker-php-ext-configure intl \
    && docker-php-ext-install zip pdo pdo_mysql mbstring bcmath exif intl \
    && docker-php-ext-enable exif intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

# Копируем весь проект
COPY . .

# Устанавливаем права на файлы и папки
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app

# Устанавливаем зависимости Laravel
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction

# Сборка ассетов Filament
RUN php artisan filament:assets --ansi

# Копируем storage для прямого доступа через public/storage
RUN rm -rf public/storage \
    && cp -r storage/app/public public/storage \
    && chown -R www-data:www-data public/storage \
    && chmod -R 755 public/storage

# Генерация ключа Laravel (если не установлен)
RUN php artisan key:generate || true

# Копируем entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["/entrypoint.sh"]
