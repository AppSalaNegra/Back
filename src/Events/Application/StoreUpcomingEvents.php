<?php

namespace App\Events\Application;

use App\Events\Domain\EventsRepository;
use App\Events\Infrastructure\EventEncoder;
use App\Events\Infrastructure\UpcomingEventsDbUpdater;
use App\Shared\Infrastructure\ActuaApiHandler;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;

/*
 * Endpoint para absteciemiento de mi base de datos con los eventos de la api de Actua en un lapso de tiempo.
 * La acción se realiza a través de la clase UpcomingEventsDbUpdater.
 * */
class StoreUpcomingEvents extends EventAction
{
    /**
     * @OA\Put(
     *     path="/store/upcomingEvents",
     *     tags={"Store"},
     *     summary="Endpoint de abstecimiento de la base de datos. Almacena eventos futuros",
     *     @OA\Response(response="200", description="Operación exitosa"),
     *     @OA\Response(response="500", description="Internal server error")
     * )
     */
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
