<?php

namespace App\Events\Application;

use App\Events\Domain\EventsRepository;
use App\Events\Infrastructure\ParentEventsDbUpdater;
use Psr\Http\Message\ResponseInterface as Response;

final class StoreParentEvents extends EventAction
{
    private ParentEventsDbUpdater $updater;
    public function __construct(EventsRepository $repository)
    {
        parent::__construct($repository);
        $this->updater = new ParentEventsDbUpdater();
    }

    protected function action(): Response
    {
        $this->updater->persistIfNotExists($this->repository);
        return $this->respondWithData();
    }
}
