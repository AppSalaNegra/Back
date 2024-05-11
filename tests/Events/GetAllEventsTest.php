<?php

namespace Tests\Events;

use App\Events\Domain\EventsRepository;
use App\Shared\Infrastructure\Actions\ActionPayload;
use Firebase\JWT\JWT;
use Mockery;
use Tests\TestCase;

final class GetAllEventsTest extends TestCase
{
    public function testActionCallsRepositoryAndReturnsArray(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(EventsRepository::class);
        $jwt = JWT::encode([], 'secret', 'HS256');
        $container->set(EventsRepository::class, $repository);

        $request = $this->createRequest('GET', '/events/get')
            ->withHeader('Authorization', 'Bearer ' . $jwt);

        $repository->shouldReceive('getFromToday')->once()->andReturn([]);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, []);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
