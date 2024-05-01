<?php

namespace App\Events\Application;

use App\Events\Domain\Event;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;

final class GetAllEventsAction extends EventAction
{
    protected function action(): Response
    {
        $events = $this->repository->getFromToday(new DateTime());
        return $this->respondWithData($events);
    }
}
