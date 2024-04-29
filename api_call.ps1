#programador de tareas en windows
$urlPost = "http://localhost:8080/posts/store"
$urlEvent = "http://localhost:8080/events/storeUpcoming"
$urlStoreParents = "http://localhost:8080/events/storeParents"

function Invoke-ApiPut {
    param (
        [string]$Url
    )
    Invoke-WebRequest -Uri $Url -Method Put
}

Invoke-ApiPut -Url $urlPost
Invoke-ApiPut -Url $urlEvent
Invoke-ApiPut -Url $urlStoreParents