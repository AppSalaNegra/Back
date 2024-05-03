<?php

namespace App\Events\Application;

use App\Events\Domain\EventsRepository;
use App\Events\Infrastructure\EventEncoder;
use App\Events\Infrastructure\UpcomingEventsDbUpdater;
use App\Shared\Infrastructure\ActuaApiHandler;
use Psr\Http\Message\ResponseInterface as Response;

class StoreUpcomingEvents extends EventAction
{
    private UpcomingEventsDbUpdater $updater;

    public function __construct(EventsRepository $repository, ActuaApiHandler $apiHandler, EventEncoder $encoder)
    {
        parent::__construct($repository);
        $this->updater = new UpcomingEventsDbUpdater($repository, $apiHandler, $encoder);
    }

    protected function action(): Response
    {
        $this->updater->persistIfNotExists();
        return $this->respondWithData();
    }
}
