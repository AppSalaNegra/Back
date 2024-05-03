<?php

namespace Tests\Posts;

use App\Posts\Domain\PostsRepository;
use App\Shared\Application\Actions\ActionPayload;
use App\Users\Application\Authentication\Token;
use App\Users\Domain\User;
use DI\Container;
use Firebase\JWT\JWT;
use Mockery;
use Tests\TestCase;

class GetAllPostsTest extends TestCase
{
    public function testActionCallsRepositoryAndReturnsArray(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(PostsRepository::class);
        $repository->shouldReceive('getAll')->once()->andReturn([]);
        $container->set(PostsRepository::class, $repository);

        $request = $this->createRequest('GET', '/posts');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, []);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
