<?php

namespace Tests\Events;

use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use App\Events\Domain\UnknowCategory;
use App\Shared\Application\Actions\ActionPayload;
use DateTime;
use DI\Container;
use Tests\TestCase;

final class GetEventsByCatTest extends TestCase
{
    public function testActionCallsRepositoryAndReturnsArrayWhenRequestHasCorrectBody(): void
    {
        $app = $this->getAppInstance();
        /** @var Container $container */
        $container = $app->getContainer();
        $events = [
            new Event(new DateTime(), new DateTime(), "", "", "", "", "", [], "", "", ""),
            new Event(new DateTime(), new DateTime(), "", "", "", "", "", [], "", "", ""),
        ];
        $eventsProphecy = $this->prophesize(EventsRepository::class);
        $eventsProphecy
            ->getByCat('7')
            ->willReturn($events)
            ->shouldBeCalledOnce();

        $container->set(EventsRepository::class, $eventsProphecy->reveal());

        $request = $this->createRequest('GET', '/events/getByCat')->withParsedBody(['cat' => 'Canalla']);
        $response = $app->handle($request);

        $payload = (string)$response->getBody();
        $expectedPayload = new ActionPayload(200, $events);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsExceptionWhenRequestHasIncorrectBody(): void
    {
        $app = $this->getAppInstance();
        $this->expectException(UnknowCategory::class);
        $request = $this->createRequest('GET', '/events/getByCat')->withParsedBody(['cat' => 'other']);
        $app->handle($request);
    }
}
