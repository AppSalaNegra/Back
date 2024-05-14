<?php

namespace Tests\Events\Infrastructure;

use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use App\Events\Domain\Exception\EventEncodeFailed;
use App\Events\Infrastructure\EventEncoder;
use App\Events\Infrastructure\ParentEventsDbUpdater;
use App\Shared\Infrastructure\ActuaApiFailed;
use App\Shared\Infrastructure\ActuaApiHandler;
use Mockery;
use Tests\TestCase;

class ParentEventsDbUpdaterTest extends TestCase
{
    private array $events = [
        [
            "startDateTime" => "2024-05-03T22:30:00",
            "finishDateTime" => "2024-05-03T23:55:00",
            "title" => "TupperSex Magic 3/05",
            "excerpt" => "",
            "url" => "https://sala-negra.com/evento/tupper-magic/tuppersex305/",
            "slug" => "tuppersex305",
            "thumbnail_url" => false,
            "cats" => false,
            "status" => "other",
            "hierarchy" => "child",
            "type" => "single"
        ]
    ];

    public function testItShouldPersistParentEventData(): void
    {
        $repository = Mockery::mock(EventsRepository::class);
        $apiHandler = Mockery::mock(ActuaApiHandler::class);
        $encoder = Mockery::mock(EventEncoder::class);
        $updater = new ParentEventsDbUpdater($repository, $apiHandler, $encoder);

        $event = Mockery::mock(Event::class);
        $title = $this->events[0]['title'];

        $apiHandler->shouldReceive('getParentEvents')->once()->andReturn($this->events);
        $repository->shouldReceive('findByTitle')->withArgs([$title])->once()->andReturn(null);
        $encoder->shouldReceive('parseDataToEvent')->withArgs($this->events)->once()->andReturn($event);
        $repository->shouldReceive('save')->once()->andReturnNull();

        $updater->persistIfNotExists();

        $this->assertTrue(true);
    }

    public function testItShouldThrowExceptionWhenEncodeParentEventFailed(): void
    {
        $this->expectException(EventEncodeFailed::class);

        $repository = Mockery::mock(EventsRepository::class);
        $apiHandler = Mockery::mock(ActuaApiHandler::class);
        $encoder = Mockery::mock(EventEncoder::class);
        $updater = new ParentEventsDbUpdater($repository, $apiHandler, $encoder);

        $title = $this->events[0]['title'];

        $apiHandler->shouldReceive('getParentEvents')->once()->andReturn($this->events);
        $repository->shouldReceive('findByTitle')->withArgs([$title])->once()->andReturn(null);
        $encoder->shouldReceive('parseDataToEvent')
            ->withArgs($this->events)
            ->once()
            ->andThrow(EventEncodeFailed::class);

        $updater->persistIfNotExists();
    }

    public function testItShouldThrowExceptionWhenApiFailsOnGetFilterEvents(): void
    {
        $this->expectException(ActuaApiFailed::class);

        $repository = Mockery::mock(EventsRepository::class);
        $apiHandler = Mockery::mock(ActuaApiHandler::class);
        $encoder = Mockery::mock(EventEncoder::class);
        $updater = new ParentEventsDbUpdater($repository, $apiHandler, $encoder);

        $apiHandler->shouldReceive('getParentEvents')->once()->andThrow(ActuaApiFailed::class);

        $updater->persistIfNotExists();
    }
}
