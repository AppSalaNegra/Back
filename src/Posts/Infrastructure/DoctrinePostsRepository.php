<?php

namespace App\Posts\Infrastructure;

use App\Posts\Domain\Post;
use App\Posts\Domain\PostsRepository;
use Doctrine\ODM\MongoDB\DocumentManager;

/*
 * Implementación de la interfaz PostsRepository utilizando Doctrine. Recoge el mapeo definido en la entidad Post
 * */
class DoctrinePostsRepository implements PostsRepository
{
    public function __construct(private readonly DocumentManager $manager)
    {
    }

    public function getAll(): array
    {
        return $this->manager->getRepository(Post::class)->findAll();
    }

    public function save(Post $post): void
    {
        $this->manager->persist($post);
        $this->manager->flush();
    }

    public function findByTitle(string $title): ?Post
    {
        return $this->manager->getRepository(Post::class)->findOneBy(['title' => $title]);
    }
}
