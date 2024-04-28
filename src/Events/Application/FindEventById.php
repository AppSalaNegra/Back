<?php

namespace App\Events\Application;

use App\Events\Domain\Event;
use App\Events\Domain\EventNotFound;
use Psr\Http\Message\ResponseInterface as Response;

class FindEventById extends EventAction
{
    protected function action(): Response
    {
        return $this->respondWithData();
    }
    public function findEventById(string $eventId): ?Event
    {
        return $this->repository->findById($eventId);
    }
}
