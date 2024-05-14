#!/bin/bash

# Obtiene el directorio donde se encuentra el script de Bash en ejecución
scriptDir=$(dirname "$0")

# Ruta relativa al archivo PHP
phpScriptPath="$scriptDir/script.php"

# Ruta completa al ejecutable de PHP (si es necesario)
phpExecutablePath="/usr/bin/php"

# Ejecuta el script PHP
"$phpExecutablePath" "$phpScriptPath"