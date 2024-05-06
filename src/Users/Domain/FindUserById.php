<?php

namespace App\Users\Domain;

use App\Users\Domain\Exception\UserNotFound;

/*
 * Clase para buscar un usuario por su ID.
 * */

class FindUserById
{
    public function __construct(private readonly UsersRepository $repository)
    {
    }

    public function findUserById(string $userId): User
    {
        $user = $this->repository->findById($userId);
        if (null === $user) {
            throw new UserNotFound();
        }
        return $user;
    }
}
