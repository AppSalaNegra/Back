<?php

namespace Tests\Posts;

use App\Posts\Domain\PostsRepository;
use App\Shared\Application\Actions\ActionPayload;
use App\Users\Application\Authentication\Token;
use App\Users\Domain\User;
use DI\Container;
use Firebase\JWT\JWT;
use Tests\TestCase;

class GetAllPostsTest extends TestCase
{
    public function testActionCallsRepositoryAndReturnsArray(): void
    {
        $app = $this->getAppInstance();
        /** @var Container $container */
        $container = $app->getContainer();
        $posts = [];
        $eventsProphecy = $this->prophesize(PostsRepository::class);
        $eventsProphecy
            ->getAll()
            ->willReturn($posts)
            ->shouldBeCalledOnce();

        $container->set(PostsRepository::class, $eventsProphecy->reveal());

        $token = Token::createToken(new User("", "", "", "", []));
        $request = $this->createRequest('GET', '/posts')->withHeader('Authorization', 'Bearer ' . $token);
        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(200, $posts);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
