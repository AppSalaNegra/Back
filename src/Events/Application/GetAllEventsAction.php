<?php

namespace App\Events\Application;

use Psr\Http\Message\ResponseInterface as Response;

final class GetAllEventsAction extends EventAction
{
    protected function action(): Response
    {
        $events = $this->repository->getAll();
        return $this->respondWithData($this->checkHierarchy($events));
    }

    private function checkHierarchy(array $events): array
    {
        foreach ($events as $event) {
            if ($event['hierarchy'] === 'child') {
                $slug = $event['slug'];
                $scriptPos = strpos($slug, '-');
                $parent = $this->repository->findParent(substr($slug, 0, $scriptPos));
                $event['excerpt'] = $parent['excerpt'];
                $event['thumbnail_url'] = $parent['thumbnail_url'];
                $event['cats'] = $parent['cats'];
            }
        }
        return $events;
    }
}
