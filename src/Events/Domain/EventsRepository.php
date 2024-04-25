<?php

namespace App\Events\Domain;

interface EventsRepository
{
    public function findById(string $id): ?Event;

    public function getAll(): array;

    public function getByCat(string $cat): array;

    public function save(Event $event): void;
}
