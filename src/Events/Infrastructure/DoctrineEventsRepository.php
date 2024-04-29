<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;

class DoctrineEventsRepository implements EventsRepository
{
    public function __construct(private readonly DocumentManager $manager)
    {
    }

    public function findById(string $id): ?Event
    {
        return $this->manager->getRepository(Event::class)->findOneBy(['_id' => $id]);
    }

    public function findByTitle(string $title): ?Event
    {
        return $this->manager->getRepository(Event::class)->findOneBy(['title' => $title]);
    }

    public function getAll(): array
    {
        return $this->manager->getRepository(Event::class)->findAll();
    }

    /**
     * @throws MongoDBException
     */
    public function getByCat(string $cat): array
    {
        $qb = $this->manager->createQueryBuilder(Event::class);
        $query = $qb->field('cats')->equals($cat)->getQuery();

        $result = $query->execute();

        return $result->toArray();
    }

    /**
     * @throws MongoDBException
     */
    public function save(Event $event): void
    {
        $this->manager->persist($event);
        $this->manager->flush();
    }
}
