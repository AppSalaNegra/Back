# Script powershell para automatizar abastecimiento de mi base de datos en máquinas windows
$urlStoreParents = "http://localhost:8080/store/parentEvents"
$urlPost = "http://localhost:8080/store/posts"
$urlEvent = "http://localhost:8080/store/upcomingEvents"

#definicion de ruta del log para el mismo directorio en el que se encuentyra el script
$scriptDirectory = Split-Path -Parent $MyInvocation.MyCommand.Definition
$logFilePath = Join-Path -Path $scriptDirectory -ChildPath "script.log"

function Invoke-ApiPut {
    param (
        [string]$Url
    )
    try {
        Invoke-WebRequest -Uri $Url -Method Put
        Add-Content -Path $logFilePath -Value "La solicitud a $Url se ha completado correctamente."
    } catch {
        Add-Content -Path $logFilePath -Value "Error al ejecutar la solicitud a $(Url): $_"
    }
}

Add-Content -Path $logFilePath -Value "Ejecución del script: $(Get-Date)"

#llamada a la funcion Invoke-ApiPut
Invoke-ApiPut -Url $urlStoreParents
Invoke-ApiPut -Url $urlPost
Invoke-ApiPut -Url $urlEvent | Out-Null

Add-Content -Path $logFilePath -Value "--------------------------------------"