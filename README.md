# GUÍA DE INSTALACIÓN

## Instalar PHP 8.1

# Para el desarrollo de esta aplicación se ha utilizado la versión [PHP 8.1.28](https://windows.php.net/download/).
> En concreto, el zip en la sección **VS16 x64 Non Thread Safe (2024-Apr-10 10:01:54)**
# Crea una carpeta en tu disco local y extrae el zip. A continuación hay que instalar la última versión disponible de la extensión de [mongodb](https://github.com/mongodb/mongo-php-driver/releases) para php
> Concretamente, descargaremos el archivo .zip compatible con la versión de PHP instalada previamente **php_mongodb-1.19.1-8.1-nts-x64.zip**
# Una vez descargado, debes extraer el fichero `php_mongodb.dll` e incluirlo en la carpeta de extensiones de PHP.
> [!TIP]
>  Por defecto esta carpeta se llama `ext`.
# Hecho esto, debes incluir esta línea en el fichero `php.ini` en el apartado de extensiones: `extension=php_mongodb.dll`
> [!TIP]
>  Es conveniente setear la ruta al directorio de PHP en las variables de entorno del sistema.
# Ejecuta el siguiente comando en tu consola para verificar que se ha realizado la instalación correctamente: `php -v`

## Instalar Composer

# Para instalar las dependencias necesitas [Composer](https://getcomposer.org/download/).
# Sigue las instrucciones del instalador, seleccionando la ruta donde se encuentra tu `php.exe`.
# Comprueba que todo funciona correctamente ejecutando el siguiente comando desde tu consola: `composer --version`

## Clona el repositorio


# Una vez instalados **PHP** y **Composer**, clona este repositorio en el directorio deseado utilizando `git clone`.
# Ahora, abre tu consola en el directorio donde hayas clonado el repositorio y ejecuta el siguiente comando: `composer install`.
> Verás que composer comienza a instalar las librerías necesarias para correr la aplicación
# Ya puedes iniciar el servidor en local utilizando el siguiente comando: `composer start`.


![image](https://github.com/AppSalaNegra/Back/assets/113618615/e62500ca-e313-42a3-9e18-ceff8240eb54)
# Prueba a llamar al siguiente endpoint desde tu navegador favorito: `localhost:8080/swagger`
> [!TIP]
> Si todo ha ido bien, deberías ver la documentación de Swagger 😄


