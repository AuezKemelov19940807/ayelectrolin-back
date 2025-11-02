# Используем готовый образ с PHP и Composer
FROM php:8.2-cli

# Устанавливаем расширения PHP
RUN apt-get update && apt-get install -y unzip git libzip-dev && docker-php-ext-install zip pdo pdo_mysql

# Копируем проект
WORKDIR /app
COPY . .

# Устанавливаем зависимости Laravel
RUN curl -sS https://getcomposer.org/installer | php && php composer.phar install --no-dev --optimize-autoloader

# Генерируем ключ Laravel
RUN php artisan key:generate

# Laravel слушает порт 8000
EXPOSE 8000

# Запуск приложения
CMD php artisan serve --host=0.0.0.0 --port=8000
