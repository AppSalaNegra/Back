<?php

namespace Tests\Events;

use App\Events\Domain\EventsRepository;
use App\Shared\Application\Actions\ActionPayload;
use Mockery;
use Tests\TestCase;

final class GetAllEventsTest extends TestCase
{
    public function testActionCallsRepositoryAndReturnsArray(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(EventsRepository::class);
        $repository->shouldReceive('getFromToday')->once()->andReturn([]);
        $container->set(EventsRepository::class, $repository);

        $request = $this->createRequest('GET', '/events/get');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, []);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
