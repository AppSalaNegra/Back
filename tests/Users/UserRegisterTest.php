<?php

namespace Tests\Users;

use App\Events\Domain\Event;
use App\Users\Domain\Exception\UserAlreadyExists;
use App\Users\Domain\User;
use App\Users\Domain\UsersRepository;
use Mockery;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    public function testUserRegisteredSuccessfully(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(UsersRepository::class);

        $repository->shouldReceive('findByEmail')->once()->andReturn(null);
        $repository->shouldReceive('save')->once();

        $container->set(UsersRepository::class, $repository);

        $request = $this->createRequest('POST', '/session/register')->withParsedBody([
            'email' => 'sadsad', 'firstName' => 'sadsad', 'lastName' => 'sadsad', 'password' => 'sadsad'
        ]);

        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUserRegisterFailsBecauseEmailAlreadyExists(): void
    {
        $this->expectException(UserAlreadyExists::class);

        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(UsersRepository::class);
        $user = Mockery::mock(User::class);

        $repository->shouldReceive('findByEmail')->once()->andReturn($user);

        $container->set(UsersRepository::class, $repository);

        $request = $this->createRequest('POST', '/session/register')->withParsedBody([
            'email' => 'sadsad', 'firstName' => 'sadsad', 'lastName' => 'sadsad', 'password' => 'sadsad'
        ]);

        $app->handle($request);
    }
}
