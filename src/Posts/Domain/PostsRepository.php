<?php

namespace App\Posts\Domain;

/*
 * Interfaz que define los métodos que debe implementar un repositorio de posts
 * */
interface PostsRepository
{
    public function getAll(): array;

    public function save(Post $post): void;

    public function findByTitle(string $title): ?Post;
}
