<?php

namespace Tests\Users;

use App\Users\Domain\FindUserById;
use App\Users\Domain\User;
use App\Users\Domain\UsersRepository;
use Firebase\JWT\JWT;
use Mockery;
use Tests\TestCase;

class RemoveUserTest extends TestCase
{
    public function testItShouldRemoveUser(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(UsersRepository::class);
        $userFinder = Mockery::mock(FindUserById::class);
        $user = Mockery::mock(User::class);
        $jwt = JWT::encode([], 'secret', 'HS256');

        $userFinder->shouldReceive('findById')->once();
        $repository->shouldReceive('findById')->once()->andReturn($user);
        $repository->shouldReceive('remove')->once();

        $container->set(UsersRepository::class, $repository);

        $request = $this->createRequest('PUT', '/users/remove')
            ->withParsedBody([
                'id' => 'userId'
            ])
            ->withHeader('Authorization', 'Bearer ' . $jwt);

        $this->assertEquals(200, $app->handle($request)->getStatusCode());
    }
}