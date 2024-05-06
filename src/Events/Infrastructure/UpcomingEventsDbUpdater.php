<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use App\Shared\Infrastructure\ActuaApiHandler;

/*
 * Esta clase se encarga de actualizar la base de datos con los eventos que se obtienen de la API de Actua.
 * Además comprueba si el evento tiene un evento padre y si es así le asigna las propiedades del padre.
 * */
class UpcomingEventsDbUpdater
{
    public function __construct(
        private readonly EventsRepository $repository,
        private readonly ActuaApiHandler $apiHandler,
        private readonly EventEncoder $encoder
    ) {
    }

    public function persistIfNotExists(): void
    {
        $events = $this->apiHandler->getUpcomingEventsData();
        foreach ($events as $eventData) {
            if (null === $this->repository->findByTitle($eventData['title'])) {
                $event = $this->encoder->parseDataToEvent($eventData);
                if ($event->hierarchy() === 'child') {
                    $this->findParent($event);
                }
                $this->repository->save($event);
            }
        }
    }

    private function findParent(Event $event): void
    {
        $title = $event->title();
        $parent = $this->repository->findByTitle(substr($title, 0, strrpos($title, ' ')));
        if (null !== $parent) {
            $event->setParentAttributes($parent->excerpt(), $parent->thumbnailUrl(), $parent->cats());
        }
    }
}
