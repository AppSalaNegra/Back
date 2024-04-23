<?php

declare(strict_types=1);

namespace App\UserEvents\Domain;

interface UserEventsRepository
{
    public function getAllUserEvents(): array;
}