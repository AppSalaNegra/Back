<?php

namespace Tests\Events;

use App\Events\Domain\EventsRepository;
use App\Shared\Application\Actions\ActionPayload;
use App\Users\Application\Authentication\Token;
use App\Users\Domain\User;
use DI\Container;
use Mockery;
use Tests\TestCase;

final class GetAllEventsTest extends TestCase
{
    public function testActionCallsRepositoryAndReturnsArray(): void
    {
        $app = $this->getAppInstance();
        $repository = Mockery::mock(EventsRepository::class);
        $token = Mockery::mock(Token::class);

        $request = $this->createRequest('GET', '/events/get');

        $events = [];

        //$token->shouldReceive('validateToken')->once()->withArgs([$request])->andReturn($request);
        $repository->shouldReceive('getFromToday')->once()->andReturn($events);

        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
