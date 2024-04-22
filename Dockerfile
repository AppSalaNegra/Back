FROM php:8.1-alpine

# Definir las variables de entorno
ENV JWT_SECRET aiCCNFxM!g47SsC59#AQip
ENV JWT_EXP 86400

# Instalar dependencias necesarias
RUN apk add --no-cache \
        $PHPIZE_DEPS \
        openssl-dev

# Instalar el controlador de MongoDB para PHP con soporte de SSL
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb