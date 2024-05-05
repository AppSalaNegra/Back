<?php

namespace App\Posts\Application;

use App\Posts\Domain\PostsRepository;
use App\Posts\Infrastructure\PostEncoder;
use App\Posts\Infrastructure\PostsDbUpdater;
use App\Shared\Infrastructure\ActuaApiHandler;
use Psr\Http\Message\ResponseInterface as Response;

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
