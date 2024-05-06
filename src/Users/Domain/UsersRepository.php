<?php

declare(strict_types=1);

namespace App\Users\Domain;

interface UsersRepository
{
    public function findByEmailAndPassword(string $email, string $password): ?User;
    public function findByEmail(string $email): ?User;
    public function findById(string $id): ?User;
    public function save(User $user): void;
    public function remove(User $user): void;
}
