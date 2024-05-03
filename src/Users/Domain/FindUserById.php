<?php

namespace App\Users\Domain;

use App\Users\Domain\Exception\UserNotFound;

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
