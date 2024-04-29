<?php

namespace App\Events\Application;

use App\Events\Domain\EventsRepository;
use App\Events\Infrastructure\UpcomingEventsDbUpdater;
use Psr\Http\Message\ResponseInterface as Response;

class StoreUpcomingEvents extends EventAction
{
    private UpcomingEventsDbUpdater $updater;

    public function __construct(EventsRepository $repository)
    {
        parent::__construct($repository);
        $this->updater = new UpcomingEventsDbUpdater();
    }

    protected function action(): Response
    {
        $this->updater->persistIfNotExists($this->repository);
        return $this->respondWithData();
    }
}
