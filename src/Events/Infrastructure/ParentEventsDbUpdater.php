<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\EventsRepository;
use App\Shared\Infrastructure\ActuaApiHandler;

/*
 * Clase que realiza la lógica de actualización de eventos en la base de datos. Obtiene los eventos de la API de Actua
 * y los persiste en la base de datos si no existen.
 */

class ParentEventsDbUpdater
{
    public function __construct(
        private readonly EventsRepository $repository,
        private readonly ActuaApiHandler $apiHandler,
        private readonly EventEncoder $encoder
    ) {
    }

    public function persistIfNotExists(): void
    {
        $events = $this->apiHandler->getParentEvents();
        foreach ($events as $eventData) {
            if (null === $this->repository->findByTitle($eventData['title'])) {
                $event = $this->encoder->parseDataToEvent($eventData);
                $this->repository->save($event);
            }
        }
    }
}
