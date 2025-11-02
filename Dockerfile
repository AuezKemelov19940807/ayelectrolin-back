FROM php:8.2-cli

# Устанавливаем расширения PHP
RUN apt-get update && apt-get install -y unzip git libzip-dev && docker-php-ext-install zip pdo pdo_mysql

# Устанавливаем Composer глобально
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копируем проект вместе с .env
WORKDIR /app
COPY . .

# Установка зависимостей Laravel
RUN composer install --no-dev --optimize-autoloader

# Генерация ключа Laravel
RUN php artisan key:generate

# Порт для сервиса
EXPOSE 8000

# Запуск приложения
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}