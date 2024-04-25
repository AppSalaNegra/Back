<?php

namespace App\Posts\Application\Actions;

use App\Posts\Domain\PostsRepository;
use App\Shared\Application\Actions\Action;
use Psr\Log\LoggerInterface;

abstract class PostAction extends Action
{
    protected PostsRepository $repository;

    public function __construct(PostsRepository $repository)
    {
        $this->repository = $repository;
    }
}
