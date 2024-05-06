<?php

namespace App\Posts\Application;

use Psr\Http\Message\ResponseInterface as Response;

/*
 * Endpoint para la obtención de todos los posts en bd.
 * */
final class GetAllPosts extends PostAction
{
    protected function action(): Response
    {
        $posts = $this->repository->getAll();
        return $this->respondWithData($posts);
    }
}
