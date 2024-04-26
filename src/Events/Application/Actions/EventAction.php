<?php

namespace App\Events\Application\Actions;

use App\Events\Domain\EventsRepository;
use App\Shared\Application\Actions\Action;

abstract class EventAction extends Action
{
    protected EventsRepository $repository;

    public function __construct(EventsRepository $repository)
    {
        $this->repository = $repository;
    }
}
