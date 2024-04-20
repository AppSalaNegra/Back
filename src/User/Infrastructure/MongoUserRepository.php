<?php

declare(strict_types=1);

namespace App\User\Infrastructure;

use App\User\Domain\User;
use App\User\Domain\UserRepository;
use Doctrine\ODM\MongoDB\DocumentManager;

class MongoUserRepository implements UserRepository
{
    public function __construct(private readonly DocumentManager $dm)
    {
    }

    #[\Override] public function findAll(): array
    {
        return $this->dm->getRepository(User::class)->findAll();
    }

    #[\Override] public function findUserOfId(int $id): User
    {
        return new User('tini.ramonda@gmail.com', 'Martin', 'Ramonda', '1234', []);
    }

    #[\Override] public function findUserByEmailAndPassword(string $email, string $password): ?User
    {
        return $this->dm->getRepository(User::class)->findOneBy(['email' => $email, 'password' => $password]);
    }

    public function save(User $user): void
    {
        $this->dm->persist($user);
        $this->dm->flush();
    }
}
