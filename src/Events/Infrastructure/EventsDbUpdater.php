<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use App\Shared\Infrastructure\ActuaApiHandler;
use DateTime;
use phpDocumentor\Reflection\Types\Boolean;

class EventsDbUpdater
{
    private ActuaApiHandler $apiHandler;
    public function __construct()
    {
        $this->apiHandler = new ActuaApiHandler();
    }
    public function persistIfNotExists(EventsRepository $repository): void
    {
        foreach ($this->apiHandler->getEventsData() as $eventData) {
            $startDateTime = DateTime::createFromFormat("Y-m-d\TH:i:s", $eventData['startDateTime']);
            $finishDateTime = DateTime::createFromFormat("Y-m-d\TH:i:s", $eventData['finishDateTime']);
            $title = $eventData['title'];
            $excerpt = $eventData['excerpt'];
            $url = $eventData['url'];
            $thumbnail_url = $eventData['thumbnail_url'];
            $cats = $eventData['cats'];
            if (is_bool($cats)) {
                $cats = [];
            }
            $event = new Event($startDateTime, $finishDateTime, $title, $excerpt, $url, $thumbnail_url, $cats);
            if (null === $repository->findByTitle($event->getTitle())) {
                $repository->save($event);
            }
        }
    }
}
