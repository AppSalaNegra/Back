<?php

namespace Tests\Users;

use App\Events\Application\FindEventById;
use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use App\Shared\Infrastructure\Actions\ActionPayload;
use App\Users\Domain\FindUserById;
use App\Users\Domain\User;
use App\Users\Domain\UsersRepository;
use Firebase\JWT\JWT;
use Mockery;
use Tests\TestCase;

class UserGetLikedEventsTest extends TestCase
{
    public function testItShouldGetLikedEvents(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(UsersRepository::class);
        $eventsRepository = Mockery::mock(EventsRepository::class);
        $userFinder = Mockery::mock(FindUserById::class);
        $eventFinder = Mockery::mock(FindEventById::class);
        $user = Mockery::mock(User::class);
        $event = Mockery::mock(Event::class);
        $jwt = JWT::encode([], 'secret', 'HS256');

        $userFinder->shouldReceive('findUserById')->once();
        $repository->shouldReceive('findById')->once()->andReturn($user);
        $user->shouldReceive('likedEvents')->once()->andReturn(['string']);
        $eventFinder->shouldReceive('findEventById')->once();
        $eventsRepository->shouldReceive('findById')->once()->andReturn($event);
        $event->shouldReceive('jsonSerialize')->once();

        $container->set(UsersRepository::class, $repository);
        $container->set(EventsRepository::class, $eventsRepository);

        $request = $this->createRequest('GET', '/users/getLikedEvents')
            ->withParsedBody([
                'id' => 'userId'
            ])
            ->withHeader('Authorization', 'Bearer ' . $jwt);

        $response = $app->handle($request);
        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(200, [[]]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
    public function testItShouldGetEmptyLikedEvents(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(UsersRepository::class);
        $eventsRepository = Mockery::mock(EventsRepository::class);
        $userFinder = Mockery::mock(FindUserById::class);
        $user = Mockery::mock(User::class);
        $jwt = JWT::encode([], 'secret', 'HS256');

        $userFinder->shouldReceive('findUserById')->once();
        $repository->shouldReceive('findById')->once()->andReturn($user);
        $user->shouldReceive('likedEvents')->once()->andReturn([]);

        $container->set(UsersRepository::class, $repository);
        $container->set(EventsRepository::class, $eventsRepository);

        $request = $this->createRequest('GET', '/users/getLikedEvents')->withParsedBody([
                'id' => 'userId'
            ])
            ->withHeader('Authorization', 'Bearer ' . $jwt);

        $response = $app->handle($request);
        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(200, []);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}