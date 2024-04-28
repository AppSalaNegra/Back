#!/bin/sh
# Este es el script de cron
# El comando curl se utiliza para llamar a la URL de tu API que ejecuta la tarea diaria
curl -X PUT http://localhost/posts/store
curl -X PUT http://localhost/events/store