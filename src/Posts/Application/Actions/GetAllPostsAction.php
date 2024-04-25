<?php

namespace App\Posts\Application\Actions;

use App\Posts\Domain\Post;
use App\Posts\Domain\PostsRepository;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class GetAllPostsAction extends PostAction
{
    private SerializerInterface $serializer;
    public function __construct(LoggerInterface $logger, PostsRepository $repository, SerializerInterface $serializer)
    {
        parent::__construct($logger, $repository);
        $this->serializer = $serializer;
    }

    protected function action(): Response
    {
        $posts = $this->repository->getAll();
        return $this->respondWithData(['posts' => $posts]);
    }

    private function updateDbFromPublicApi(): void
    {
        $client = new Client();
        $response = $client->request('POST', 'https://sala-negra.com/actua_public_api_v1/get_posts');
        if ($response->getStatusCode() === 200) {
            $data = $response->getBody()->getContents();
            $postsData = json_decode($data, true);
            foreach ($postsData as $postData) {
                /** @var Post $post */
                $post = $this->serializer->deserialize(json_encode($postData), Post::class, 'json');
                if (null !== $this->repository->findByTitle($post->getTitle())) {
                    $this->repository->save($post);
                }
            }
        }
    }
}
