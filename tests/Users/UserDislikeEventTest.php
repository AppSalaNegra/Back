<?php

namespace Tests\Users;

use App\Shared\Application\Actions\ActionPayload;
use App\Users\Application\Authentication\Token;
use App\Users\Domain\User;
use App\Users\Domain\UsersRepository;
use DI\Container;
use Tests\TestCase;

class UserDislikeEventTest extends TestCase
{
    public function testItShouldRemoveLikedEvent(): void
    {
        $app = $this->getAppInstance();
        /** @var Container $container */
        $container = $app->getContainer();
        $user = new User("", "", "", "", []);
        $userProphecy = $this->prophesize(UsersRepository::class);
        $userProphecy
            ->save($user)
            ->shouldBeCalledOnce();

        $container->set(UsersRepository::class, $userProphecy->reveal());

        $token = Token::createToken(new User("", "", "", "", []));
        $request = $this->createRequest('PUT', '/users/dislike')
            ->withParsedBody(['userId' => 'Canalla', 'eventId' => 'x'])
            ->withHeader('Authorization', 'Bearer ' . $token);

        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(200);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
