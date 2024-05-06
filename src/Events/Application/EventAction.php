<?php

namespace App\Events\Application;

use App\Events\Domain\EventsRepository;
use App\Shared\Application\Actions\Action;

/*
 * Clase abstracta de la que heredan los casos de uso para la entidad Event
 * */
abstract class EventAction extends Action
{
    protected EventsRepository $repository;

    public function __construct(EventsRepository $repository)
    {
        $this->repository = $repository;
    }
}
