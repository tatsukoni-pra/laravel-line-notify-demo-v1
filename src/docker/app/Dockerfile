FROM php:8.0-fpm-alpine3.13

# package install
RUN apk update && \
    apk add --no-cache \
    autoconf \
    gcc \
    g++ \
    git \
    icu-dev \
    libzip-dev \
    make \
    oniguruma-dev && \
    docker-php-ext-install intl pdo_mysql bcmath

# composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# copy setting
COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www/
