FROM php:8.1-alpine

# Instalar dependencias necesarias
RUN apk add --no-cache \
        $PHPIZE_DEPS \
        openssl-dev

# Instalar el controlador de MongoDB para PHP con soporte de SSL
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb