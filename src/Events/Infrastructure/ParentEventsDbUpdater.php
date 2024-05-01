<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\EventsRepository;
use App\Shared\Infrastructure\ActuaApiHandler;

class ParentEventsDbUpdater
{
    private ActuaApiHandler $apiHandler;

    public function __construct()
    {
        $this->apiHandler = new ActuaApiHandler();
    }

    public function persistIfNotExists(EventsRepository $repository): void
    {
        foreach ($this->apiHandler->getParentEvents() as $eventData) {
            if (null === $repository->findByTitle($eventData['title'])) {
                $event = EventEncoder::parseDataToEvent($eventData);
                $repository->save($event);
            }
        }
    }
}
