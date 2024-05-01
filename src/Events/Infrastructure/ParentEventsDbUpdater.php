<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use App\Shared\Infrastructure\ActuaApiHandler;
use DateTime;

final class ParentEventsDbUpdater
{
    private ActuaApiHandler $apiHandler;

    public function __construct()
    {
        $this->apiHandler = new ActuaApiHandler();
    }

    public function persistIfNotExists(EventsRepository $repository): void
    {
        foreach ($this->apiHandler->getParentEventsTwoMonthsAgo() as $eventData) {
            if (null === $repository->findByTitle($eventData['title'])) {
                $event = EventEncoder::parseDataToEvent($eventData);
                $repository->save($event);
            }
        }
    }
}
