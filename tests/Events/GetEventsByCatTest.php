<?php

namespace Tests\Events;

use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use App\Events\Domain\UnknowCategory;
use App\Shared\Application\Actions\ActionPayload;
use App\Users\Application\Authentication\Token;
use App\Users\Domain\User;
use DateTime;
use DI\Container;
use Mockery;
use Tests\TestCase;

final class GetEventsByCatTest extends TestCase
{
    public function testActionCallsRepositoryAndReturnsArrayWhenRequestHasCorrectBody(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(EventsRepository::class);
        $repository->shouldReceive('getByCat')->once()->andReturn([]);
        $container->set(EventsRepository::class, $repository);

        $request = $this->createRequest('GET', '/events/getByCat')
            ->withParsedBody(['cat' => 'Destacado']);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, []);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsExceptionWhenRequestHasIncorrectBody(): void
    {
        $app = $this->getAppInstance();
        $this->expectException(UnknowCategory::class);

        $request = $this->createRequest('GET', '/events/getByCat')
            ->withParsedBody(['cat' => 'other']);
        $app->handle($request);
    }
}
