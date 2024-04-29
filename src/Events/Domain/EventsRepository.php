<?php

namespace App\Events\Domain;

interface EventsRepository
{
    public function findById(string $id): ?Event;
    public function findByTitle(string $title): ?Event;
    public function findParent(string $slug): ?Event;
    public function getAll(): array;
    public function getByCat(string $cat): array;
    public function save(Event $event): void;
}
