<?php

namespace Tests\Users;

use App\Users\Domain\Exception\UserNotFound;
use App\Users\Domain\FindUserById;
use App\Users\Domain\User;
use App\Users\Domain\UsersRepository;
use MongoDB\BSON\ObjectId;
use Tests\TestCase;

final class FindUserByIdTest extends TestCase
{
    public function testItShouldFindUser(): void
    {
        $id = new ObjectId();
        $expectedUser = new User("", "", "", "", []);
        $mockRepository = $this->createMock(UsersRepository::class);
        $mockRepository->method('findById')->with($id)->willReturn($expectedUser);

        $userById = new FindUserById($mockRepository);
        $result = $userById->findUserById($id);
        $this->assertSame($expectedUser, $result);
    }

    public function testItShouldThrowExceptionWhenUserNotFound(): void
    {
        $id = new ObjectId();
        $mockRepository = $this->createMock(UsersRepository::class);
        $mockRepository->method('findById')->with($id)->willReturn(null);
        $userById = new FindUserById($mockRepository);
        $this->expectException(UserNotFound::class);
        $userById->findUserById($id);
    }
}
