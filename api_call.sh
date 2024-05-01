#!/bin/sh
# Este es el script de cron para automatizar el abastecimiento de mi base de datos si la api se ejecutara en una máquina linux
curl -X PUT http://localhost/events/storeParents
curl -X PUT http://localhost/posts/store
curl -X PUT http://localhost/events/storeUpcoming