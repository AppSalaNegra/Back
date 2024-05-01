<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use App\Shared\Infrastructure\ActuaApiHandler;

class UpcomingEventsDbUpdater
{
    private ActuaApiHandler $apiHandler;

    public function __construct()
    {
        $this->apiHandler = new ActuaApiHandler();
    }

    public function persistIfNotExists(EventsRepository $repository): void
    {
        foreach ($this->apiHandler->getUpcomingEventsData() as $eventData) {
            if (null === $repository->findByTitle($eventData['title'])) {
                $event = EventEncoder::parseDataToEvent($eventData);
                if ($event->hierarchy() === 'child') {
                    $this->findParent($event, $repository);
                }
                $repository->save($event);
            }
        }
    }

    private function findParent(Event $event, EventsRepository $repository): void
    {
        $title = $event->title();
        $parent = $repository->findByTitle(substr($title, 0, strrpos($title, ' ')));
        if (null !== $parent) {
            $event->setParentAttributes($parent->excerpt(), $parent->thumbnailUrl(), $parent->cats());
        }
    }
}
