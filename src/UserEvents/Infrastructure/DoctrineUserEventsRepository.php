<?php

declare(strict_types=1);

namespace App\UserEvents\Infrastructure;

use App\UserEvents\Domain\UserEventsRepository;

final class DoctrineUserEventsRepository implements UserEventsRepository
{
    public function __construct(private readonly DocumentManager $manager)
    {
    }

    public function getAllUserEvents(): array
    {
        // TODO: Implement getAllUserEvents() method.
    }
}