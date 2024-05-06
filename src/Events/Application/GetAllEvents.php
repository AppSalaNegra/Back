<?php

namespace App\Events\Application;

use Psr\Http\Message\ResponseInterface as Response;

/*
 * Caso de uso sencillo que recoge todos los eventos que haya en la bd desde el día hoy
 * */
final class GetAllEvents extends EventAction
{
    protected function action(): Response
    {
        $events = $this->repository->getFromToday();
        return $this->respondWithData($events);
    }
}
