<?php

namespace App\Posts\Application;

use App\Posts\Domain\PostsRepository;
use App\Shared\Application\Actions\Action;

/*
 * Clase de la que heredan todos los endpoints de posts.
 * */
abstract class PostAction extends Action
{
    protected PostsRepository $repository;

    public function __construct(PostsRepository $repository)
    {
        $this->repository = $repository;
    }
}
