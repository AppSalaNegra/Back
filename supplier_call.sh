#!/bin/bash

# directorio actual del script bash
scriptDir=$(dirname "$0")

# directorio del script php
phpScriptPath="$scriptDir/script.php"

# ruta al ejecutable de php
phpExecutablePath="/usr/bin/php"

# comando
"$phpExecutablePath" "$phpScriptPath"