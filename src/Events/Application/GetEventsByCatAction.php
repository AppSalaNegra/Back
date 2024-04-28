<?php

namespace App\Events\Application;

use Psr\Http\Message\ResponseInterface as Response;

final class GetEventsByCatAction extends EventAction
{
    protected function action(): Response
    {
        $data = $this->getFormData();
        $cat = $data['cat'];
        $events = $this->repository->getByCat($cat);
        return $this->respondWithData(['events' => $events]);
    }
}
