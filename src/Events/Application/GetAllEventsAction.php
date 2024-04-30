<?php

namespace App\Events\Application;

use App\Events\Domain\Event;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;

final class GetAllEventsAction extends EventAction
{
    protected function action(): Response
    {
        $events = $this->repository->getFromToday(new DateTime());
        return $this->respondWithData($this->checkHierarchy($events));
    }

    private function checkHierarchy(array $events): array
    {
        /** @var Event $event */
        foreach ($events as $event) {
            if ($event->hierarchy() === 'child') {
                $title = $event->title();
                $parent = $this->repository->findByTitle(substr($title, 0, strrpos($title, ' ')));
                if (null !== $parent) {
                    $event->setParentAttributes($parent->excerpt(), $parent->thumbnailUrl(), $parent->cats());
                }
            }
        }
        return $events;
    }
}
