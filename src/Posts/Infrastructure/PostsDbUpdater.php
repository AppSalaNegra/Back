<?php

namespace App\Posts\Infrastructure;

use App\Posts\Domain\Post;
use App\Posts\Domain\PostsRepository;
use App\Shared\Infrastructure\ActuaApiHandler;
use DateTime;

class PostsDbUpdater
{
    private ActuaApiHandler $apiHandler;

    public function __construct()
    {
        $this->apiHandler = new ActuaApiHandler();
    }

    public function persistIfNotExists(PostsRepository $repository): void
    {
        foreach ($this->apiHandler->getPostsData() as $postData) {
            if (null == $repository->findByTitle($postData['title'])) {
                $post = $this->encodePostData($postData);
                $repository->save($post);
            }
        }
    }

    private function encodePostData(array $postData): Post
    {
        $dateTime = DateTime::createFromFormat("Y-m-d\TH:i:s", $postData['dateTime']);
        $title = $postData['title'];
        $excerpt = $postData['excerpt'];
        $url = $postData['url'];
        $slug = $postData['slug'];
        $thumbnail_url = $postData['thumbnail_url'];
        $cats = is_bool($postData['cats']) ? [] : $postData['cats'];
        $status = $postData['status'];
        return new Post($dateTime, $title, $excerpt, $url, $slug, $thumbnail_url, $cats, $status);
    }
}
