<?php

namespace App\Posts\Application;

use Psr\Http\Message\ResponseInterface as Response;

final class GetAllPostsAction extends PostAction
{
    protected function action(): Response
    {
        $posts = $this->repository->getAll();
        return $this->respondWithData($posts);
    }
}
