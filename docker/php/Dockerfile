# Используем официальный образ PHP с поддержкой FPM
FROM php:8.3-fpm

# Установка необходимых системных зависимостей
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Установка расширения redis
RUN pecl install redis \
    && docker-php-ext-enable redis

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Установка рабочей директории
WORKDIR /var/www

# Копируем файлы проекта в контейнер
COPY ./src .

RUN chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www
