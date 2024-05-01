<?php

namespace App\Events\Application;

use Psr\Http\Message\ResponseInterface as Response;

final class GetAllEvents extends EventAction
{
    protected function action(): Response
    {
        $events = $this->repository->getFromToday();
        return $this->respondWithData($events);
    }
}
