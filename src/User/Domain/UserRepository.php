<?php

declare(strict_types=1);

namespace App\User\Domain;

interface UserRepository
{
    public function findAll(): array;
    public function findUserOfId(int $id): User;
    public function findUserByEmailAndPassword(string $email, string $password): ?User;
    public function save(User $user): void;
}
