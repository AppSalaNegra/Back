<?php

namespace App\Events\Domain;

/*
 * EventsRepository for Event db operations
 * */

interface EventsRepository
{
    public function findById(string $id): ?Event;
    public function findByTitle(string $title): ?Event;
    public function getFromToday(): array;
    public function getByCat(string $cat): array;
    public function save(Event $event): void;
}
