<?php

namespace App\Events\Domain;

use DateTime;

interface EventsRepository
{
    public function findById(string $id): ?Event;
    public function findByTitle(string $title): ?Event;
    public function getFromToday(): array;
    public function getByCat(string $cat): array;
    public function save(Event $event): void;
}
