<?php

namespace App\Events\Infrastructure;

use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;

/*
 * Implementación del repositorio de eventos con Doctrine. Utiliza el mapeo por etiquetas definido en la entidad Event.
 * */
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

    public function getFromToday(): array
    {
        $qb = $this->manager->createQueryBuilder(Event::class);
        $qb->field('finishDateTime')->gt(new DateTime());
        return $qb->getQuery()->execute()->toArray();
    }

    /**
     * @throws MongoDBException
     */
    public function getByCat(string $cat): array
    {
        $qb = $this->manager->createQueryBuilder(Event::class);
        $qb->field('cats.' . $cat)->exists(true);
        $qb->field('finishDateTime')->gt(new DateTime());
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
