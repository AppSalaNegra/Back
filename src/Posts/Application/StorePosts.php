<?php

namespace App\Posts\Application;

use App\Posts\Domain\PostsRepository;
use App\Posts\Infrastructure\PostEncoder;
use App\Posts\Infrastructure\PostsDbUpdater;
use App\Shared\Infrastructure\ActuaApiHandler;
use Psr\Http\Message\ResponseInterface as Response;

/*
 * Endpoint de abastecimiento de mi base de datos. Se encarga de actualizar la base de datos con los posts de Actua.
 * */
class StorePosts extends PostAction
{
    private PostsDbUpdater $updater;

    public function __construct(PostsRepository $repository, ActuaApiHandler $apiHandler, PostEncoder $encoder)
    {
        parent::__construct($repository);
        $this->updater = new PostsDbUpdater($repository, $apiHandler, $encoder);
    }

    protected function action(): Response
    {
        $this->updater->persistIfNotExists($this->repository);
        return $this->respondWithData();
    }
}
