<?php

namespace Tests\Events;

use App\Events\Application\FindEventById;
use App\Events\Domain\Event;
use App\Events\Domain\EventNotFound;
use App\Events\Domain\EventsRepository;
use DateTime;
use MongoDB\BSON\ObjectId;
use Tests\TestCase;

final class FindEventByIdTest extends TestCase
{
    public function testItShouldFindEvent(): void
    {
        $id = new ObjectId();
        $expectedEvent = new Event(new DateTime(), new DateTime(), "", "", "", "", "", [], "", "", "");
        $mockRepository = $this->createMock(EventsRepository::class);
        $mockRepository->method('findById')->with($id)->willReturn($expectedEvent);

        $findEventById = new FindEventById($mockRepository);
        $resultEvent = $findEventById->findEventById($id);
        $this->assertSame($expectedEvent, $resultEvent);
    }

    public function testItShouldThrowExceptionWhenEventNotFound(): void
    {
        $id = new ObjectId();
        $mockRepository = $this->createMock(EventsRepository::class);
        $mockRepository->method('findById')->with($id)->willReturn(null);
        $findEventById = new FindEventById($mockRepository);
        $this->expectException(EventNotFound::class);
        $findEventById->findEventById($id);
    }
}
