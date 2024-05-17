FROM php:8.1-alpine

# Definir las variables de entorno
ENV JWT_SECRET aiCCNFxM!g47SsC59#AQip
ENV JWT_EXP 86400

# Instalar dependencias necesarias
RUN apk add --no-cache \
        $PHPIZE_DEPS \
        openssl-dev \
        dcron

# Instalar el controlador de MongoDB para PHP con soporte de SSL
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb

# Copiar el script PHP desde la máquina local al contenedor
COPY supplier.php /usr/local/bin/supplier.php

# Dar permisos de ejecución al script PHP (opcional)
RUN chmod +x /usr/local/bin/supplier.php

# Crear el archivo crontab
RUN echo "0 19 * * * php /usr/local/bin/supplier.php >> /var/log/cron.log 2>&1" > /etc/crontabs/root

# Asegurar que el archivo de log existe
RUN touch /var/log/cron.log

# Comando para ejecutar PHP-FPM y crond en segundo plano
CMD ["sh", "-c", "php-fpm & crond -f"]