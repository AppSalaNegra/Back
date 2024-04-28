<?php

namespace App\Events\Application;

use App\Events\Domain\EventsRepository;
use App\Events\Infrastructure\EventsDbUpdater;
use Psr\Http\Message\ResponseInterface as Response;

class StoreEvents extends EventAction
{
    private EventsDbUpdater $updater;

    public function __construct(EventsRepository $repository)
    {
        parent::__construct($repository);
        $this->updater = new EventsDbUpdater();
    }

    protected function action(): Response
    {
        $this->updater->persistIfNotExists($this->repository);
        return $this->respondWithData();
    }
}
