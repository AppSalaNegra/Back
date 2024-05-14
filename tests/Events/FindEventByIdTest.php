<?php

namespace Tests\Events;

use App\Events\Application\FindEventById;
use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use App\Events\Domain\Exception\EventNotFound;
use Mockery;
use Tests\TestCase;

final class FindEventByIdTest extends TestCase
{
    public function testItShouldFindEvent(): void
    {
        $repository = Mockery::mock(EventsRepository::class);
        $finder = new FindEventById($repository);

        $id = 'randomId';
        $event = Mockery::mock(Event::class);

        $repository->shouldReceive('findById')->withArgs([$id])->andReturn($event);
        $resultEvent = $finder->findEventById($id);

        $this->assertEquals($event, $resultEvent);
    }

    public function testItShouldThrowExceptionWhenEventNotFound(): void
    {
        $this->expectException(EventNotFound::class);
        $repository = Mockery::mock(EventsRepository::class);
        $finder = new FindEventById($repository);

        $id = 'randomId';

        $repository->shouldReceive('findById')->withArgs([$id])->andThrow(EventNotFound::class);
        $finder->findEventById($id);
    }
}
