<?php

namespace App\Events\Application;

use App\Events\Domain\EventsRepository;
use App\Events\Infrastructure\EventEncoder;
use App\Events\Infrastructure\ParentEventsDbUpdater;
use App\Shared\Infrastructure\ActuaApiHandler;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;

/*
 * Endpoint para abastecimiento de mi base de datos con los eventos padres de la api de Actua.
 * Obtiene una lista y la almacena a través de la clase ParentEventsDbUpdater.
 * */
final class StoreParentEvents extends EventAction
{
    /**
     * @OA\Put(
     *     path="/store/parentEvents",
     *     tags={"Store"},
     *     summary="Endpoint de abstecimiento de la base de datos.Almacena eventos principales",
     *     @OA\Response(response="200", description="Operación exitosa"),
     *     @OA\Response(response="500", description="Internal server error")
     * )
     */
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
