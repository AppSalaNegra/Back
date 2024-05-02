<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\EventsRepository;
use App\Shared\Infrastructure\ActuaApiHandler;

final class ParentEventsDbUpdater
{
    public function __construct(
        private readonly EventsRepository $repository,
        private readonly ActuaApiHandler $apiHandler
    )
    {
    }

    public function persistIfNotExists(): void
    {
        $events = $this->apiHandler->getParentEvents();
        foreach ($events as $eventData) {
            if (null === $this->repository->findByTitle($eventData['title'])) {
                $event = EventEncoder::parseDataToEvent($eventData);
                $this->repository->save($event);
            }
        }
    }
}
