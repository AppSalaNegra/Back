<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use App\Shared\Infrastructure\ActuaApiHandler;

class UpcomingEventsDbUpdater
{
    public function __construct(
        private readonly EventsRepository $repository,
        private readonly ActuaApiHandler $apiHandler
    ) {
    }

    public function persistIfNotExists(): void
    {
        foreach ($this->apiHandler->getUpcomingEventsData() as $eventData) {
            if (null === $this->repository->findByTitle($eventData['title'])) {
                $event = EventEncoder::parseDataToEvent($eventData);
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
