<?php

namespace App\Events\Application;

use App\Events\Domain\EventsRepository;
use App\Events\Infrastructure\EventEncoder;
use App\Events\Infrastructure\ParentEventsDbUpdater;
use App\Shared\Infrastructure\ActuaApiHandler;
use Psr\Http\Message\ResponseInterface as Response;

/*
 * Endpoint para absteciemiento de mi base de datos con los eventos padres de la api de Actua.
 * Obtiene una lista y la almacena a través de la clase ParentEventsDbUpdater.
 * */
final class StoreParentEvents extends EventAction
{
    private readonly ParentEventsDbUpdater $updater;

    public function __construct(EventsRepository $repository, ActuaApiHandler $apiHandler, EventEncoder $encoder)
    {
        parent::__construct($repository);
        $this->updater = new ParentEventsDbUpdater($repository, $apiHandler, $encoder);
    }

    protected function action(): Response
    {
        $this->updater->persistIfNotExists();
        return $this->respondWithData();
    }
}
