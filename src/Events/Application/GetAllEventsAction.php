<?php

namespace App\Events\Application;

use App\Events\Domain\Event;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;

final class GetAllEventsAction extends EventAction
{
    protected function action(): Response
    {
        $events = $this->repository->getAll();
        return $this->respondWithData($this->checkHierarchyAndDate($events));
    }

    private function checkHierarchyAndDate(array $events): array
    {
        /** @var Event $event */
        foreach ($events as $key => $event) {
            if ($event->hierarchy() === 'child') {
                $title = $event->title();
                $parent = $this->repository->findByTitle(substr($title, 0, strrpos($title, ' ')));
                if (null !== $parent) {
                    $event->setParentAttributes($parent->excerpt(), $parent->thumbnailUrl(), $parent->cats());
                }
            }
            $currentTime = new DateTime();
            $currentDate = $currentTime->format('Y-m-d');
            $eventDate = $event->startDateTime()->format('Y-m-d');
            if ($eventDate < $currentDate) {
                unset($events[$key]);
            }
        }
        return $events;
    }
}
