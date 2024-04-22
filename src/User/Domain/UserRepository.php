<?php

declare(strict_types=1);

namespace App\User\Domain;

interface UserRepository
{
    public function findByEmailAndPassword(string $email, string $password): ?User;
    public function findByEmail(string $email): ?User;
    public function save(User $user): void;
}
