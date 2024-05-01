#!/bin/sh
# Este es el script de cron para automatizar el abastecimiento de mi base de datos si la api se ejecutara en una máquina linux
curl -X PUT http://localhost/store/parentEvents
curl -X PUT http://localhost/store/posts
curl -X PUT http://localhost/store/upcomingEvents