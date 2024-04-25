<?php

namespace App\Posts\Application\Actions;

use App\Posts\Domain\Post;
use App\Posts\Domain\PostNotSavedException;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;

final class GetAllPostsAction extends PostAction
{
    protected function action(): Response
    {
        $this->updateDbFromPublicApi();
        $posts = $this->repository->getAll();
        return $this->respondWithData($posts);
    }

    private function updateDbFromPublicApi(): void
    {
        $client = new Client();
        $response = $client->request('POST', 'https://sala-negra.com/actua_public_api_v1/get_posts');
        if ($response->getStatusCode() === 200) {
            $data = $response->getBody()->getContents();
            $dataArray = json_decode($data, true);
            $this->persistIfNotExists($dataArray['posts']);
        }
    }

    private function persistIfNotExists(array $postsArray): void
    {
        foreach ($postsArray as $postData) {
            $dateTime = DateTime::createFromFormat("Y-m-d\TH:i:s", $postData['dateTime']);
            $title = $postData['title'];
            $excerpt = $postData['excerpt'];
            $url = $postData['url'];
            $thumbnail_url = $postData['thumbnail_url'];
            $post = new Post($dateTime, $title, $excerpt, $url, $thumbnail_url);
            if (null === $this->repository->findByTitle($post->getTitle())) {
                $this->repository->save($post);
            }
        }
    }
}
