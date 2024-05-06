<?php

namespace App\Posts\Infrastructure;

use App\Posts\Domain\Post;
use App\Posts\Domain\PostsRepository;
use App\Shared\Infrastructure\ActuaApiHandler;
use DateTime;

/*
 * Esta clase incluye la lógica para actualizar la base de datos de posts.
 * Se encarga de obtener los datos de la API, parsearlos y persistirlos en la base de datos si no existen.
 * */

class PostsDbUpdater
{
    public function __construct(
        private readonly PostsRepository $repository,
        private readonly ActuaApiHandler $apiHandler,
        private readonly PostEncoder $encoder
    ) {
    }

    public function persistIfNotExists(): void
    {
        $posts = $this->apiHandler->getPostsData();
        foreach ($posts as $postData) {
            if (null == $this->repository->findByTitle($postData['title'])) {
                $post = $this->encoder->parseDataToPost($postData);
                $this->repository->save($post);
            }
        }
    }
}
