#programador de tareas en windows
$urlStoreParents = "http://localhost:8080/events/storeParents"
$urlPost = "http://localhost:8080/posts/store"
$urlEvent = "http://localhost:8080/events/storeUpcoming"

function Invoke-ApiPut {
    param (
        [string]$Url
    )
    Invoke-WebRequest -Uri $Url -Method Put
}

Invoke-ApiPut -Url $urlPost
Invoke-ApiPut -Url $urlEvent
Invoke-ApiPut -Url $urlStoreParents

#añadir log de ejecucion del script