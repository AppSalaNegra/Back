<?php

namespace App\Events\Application;

use Psr\Http\Message\ResponseInterface as Response;

final class GetAllEventsAction extends EventAction
{
    protected function action(): Response
    {
        $events = $this->repository->getAll();
        return $this->respondWithData(['events' => $events]);
    }
}
