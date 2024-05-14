<?php

namespace Tests\Events;

use App\Events\Domain\EventsRepository;
use App\Events\Domain\Exception\UnknowCategory;
use App\Shared\Infrastructure\Actions\ActionPayload;
use Firebase\JWT\JWT;
use Mockery;
use Tests\TestCase;

final class GetEventsByCatTest extends TestCase
{
    public function testActionCallsRepositoryAndReturnsArrayWhenRequestHasCorrectBody(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(EventsRepository::class);
        $jwt = JWT::encode([], 'secret', 'HS256');

        $repository->shouldReceive('getByCat')->once()->andReturn([]);
        $container->set(EventsRepository::class, $repository);

        $request = $this->createRequest('GET', '/events/getByCat')
            ->withParsedBody(['cat' => 'Destacado'])
            ->withHeader('Authorization', 'Bearer ' . $jwt);
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
        $jwt = JWT::encode([], 'secret', 'HS256');

        $request = $this->createRequest('GET', '/events/getByCat')
            ->withParsedBody(['cat' => 'other'])
            ->withHeader('Authorization', 'Bearer ' . $jwt);
        $app->handle($request);
    }
}
