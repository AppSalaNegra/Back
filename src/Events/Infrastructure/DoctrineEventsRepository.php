<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use DateTime;
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

    public function getFromToday(DateTime $dateToday): array
    {
        $repository = $this->manager->getRepository(Event::class);
        $qb = $repository->createQueryBuilder();
        $qb->field('finishDateTime')->gt($dateToday);
        return $qb->getQuery()->execute()->toArray();
    }

    /**
     * @throws MongoDBException
     */
    public function getByCat(string $cat): array
    {
        $repository = $this->manager->getRepository(Event::class);
        $qb = $repository->createQueryBuilder();
        $qb->field('cats')->elemMatch(['$eq' => $cat]);
        $query = $qb->getQuery();
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
