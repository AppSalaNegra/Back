<?php

namespace App\Posts\Domain;

interface PostsRepository
{
    public function getAll(): array;

    public function save(Post $post): void;

    public function findByTitle(string $title): ?Post;
}
