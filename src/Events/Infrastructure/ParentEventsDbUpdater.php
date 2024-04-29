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
            $startDateTime  = DateTime::createFromFormat("Y-m-d\TH:i:s", $eventData['startDateTime']);
            $finishDateTime = DateTime::createFromFormat("Y-m-d\TH:i:s", $eventData['finishDateTime']);
            $title          = $eventData['title'];
            $excerpt        = $eventData['excerpt'];
            $url            = $eventData['url'];
            $slug           = $eventData['slug'];
            $thumbnail_url  = $eventData['thumbnail_url'];
            $cats           = is_bool($eventData['cats']) ? [] : $eventData['cats'];
            $status         = $eventData['status'];
            $hierarchy      = $eventData['hierarchy'];
            $type           = $eventData['type'];
            $event          = new Event(
                $startDateTime,
                $finishDateTime,
                $title,
                $excerpt,
                $url,
                $slug,
                $thumbnail_url,
                $cats,
                $status,
                $hierarchy,
                $type
            );
            if (null === $repository->findByTitle($event->title())) {
                $repository->save($event);
            }
        }
    }
}
