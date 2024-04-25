<?php

declare(strict_types=1);

namespace App\Users\Infrastructure;

use App\Users\Domain\User;
use App\Users\Domain\UserRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;

class DoctrineUserRepository implements UserRepository
{
    public function __construct(private readonly DocumentManager $manager)
    {
    }

    public function findById(string $id): ?User
    {
        return $this->manager->getRepository(User::class)->findOneBy(['id' => $id]);
    }

    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        return $this->manager->getRepository(User::class)->findOneBy(['email' => $email, 'password' => $password]);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->manager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    /**
     * @throws MongoDBException
     */
    public function save(User $user): void
    {
        $this->manager->persist($user);
        $this->manager->flush();
    }
}
