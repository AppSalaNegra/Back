<?php

namespace App\Events\Application;

use App\Events\Domain\Event;
use App\Events\Domain\EventNotFound;
use App\Events\Domain\EventsRepository;

/*
 * Caso de uso para encontrar un usuario por Id. Si no lo encuentra lanza una excepción con codigo http 404
 * */
class FindEventById
{
    public function __construct(private readonly EventsRepository $repository)
    {
    }

    public function findEventById(string $eventId): Event
    {
        $event = $this->repository->findById($eventId);
        if (null === $event) {
            throw new EventNotFound();
        }
        return $event;
    }
}
