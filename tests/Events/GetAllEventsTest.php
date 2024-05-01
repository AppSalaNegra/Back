<?php

namespace Tests\Events;

use App\Events\Domain\EventsRepository;
use App\Shared\Application\Actions\ActionPayload;
use App\Users\Application\Authentication\Token;
use App\Users\Domain\User;
use DI\Container;
use Tests\TestCase;

final class GetAllEventsTest extends TestCase
{
    public function testActionCallsRepositoryAndReturnsArray(): void
    {
        $app = $this->getAppInstance();
        /** @var Container $container */
        $container = $app->getContainer();
        $events = [];
        $eventsProphecy = $this->prophesize(EventsRepository::class);
        $eventsProphecy
            ->getFromToday()
            ->willReturn($events)
            ->shouldBeCalledOnce();

        $container->set(EventsRepository::class, $eventsProphecy->reveal());

        $token = Token::createToken(new User("", "", "", "", []));
        $request = $this->createRequest('GET', '/events/get')->withHeader('Authorization', 'Bearer ' . $token);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $events);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
