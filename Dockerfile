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

# Copiar el script de cron job al contenedor
COPY cron.sh /usr/src/cron.sh

# Dar permisos de ejecución al script de cron
RUN chmod +x /usr/src/cron.sh

# Configurar el cron job
RUN echo "0 0 * * * /usr/src/cron.sh" | crontab -

# Ejecutar PHP-FPM
CMD ["php-fpm"]