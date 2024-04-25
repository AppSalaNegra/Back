<?php

namespace App\Events\Application\Actions;

use App\Events\Domain\EventsRepository;
use App\Shared\Application\Actions\Action;
use Psr\Log\LoggerInterface;

abstract class EventAction extends Action
{
    protected EventsRepository $repository;

    public function __construct(LoggerInterface $logger, EventsRepository $repository)
    {
        parent::__construct($logger);
        $this->repository = $repository;
    }
}
