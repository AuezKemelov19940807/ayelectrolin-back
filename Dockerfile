FROM php:8.2-cli

# Устанавливаем зависимости
RUN apt-get update && apt-get install -y \
    unzip git libzip-dev libxml2-dev libonig-dev curl \
    && docker-php-ext-install zip pdo pdo_mysql mbstring bcmath

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копируем проект
WORKDIR /app
COPY . .

# Права для www-data
RUN chown -R www-data:www-data /app

# Установка зависимостей Laravel
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction

# Генерация ключа (если ещё нет)
RUN php artisan key:generate

# Порт для Laravel
EXPOSE 8000

# Запуск приложения
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
