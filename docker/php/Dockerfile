FROM php:8.3.16-apache

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2.8.9 /usr/bin/composer /usr/bin/composer

# OPcache
RUN docker-php-ext-install opcache

COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html

# Copiar el proyecto dentro de Docker
COPY . /var/www/html

# Instalar dependencias de Laravel
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# Permisos de Laravel
RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Optimizar Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 80