<?php

namespace Tests\Users;

use App\Users\Application\Authentication\Token;
use App\Users\Domain\Exception\UserNotFound;
use App\Users\Domain\User;
use App\Users\Domain\UsersRepository;
use Mockery;
use Slim\Exception\HttpNotFoundException;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    public function testUserLogin(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(UsersRepository::class);
        $user = Mockery::mock(User::class);
        $token = Mockery::mock(Token::class);

        $repository->shouldReceive('findByEmailAndPassword')->once()->andReturn($user);
        $token->shouldReceive('createToken')->withArgs([$user])->once()->andReturn();
        $user->shouldReceive('id')->once();
        $user->shouldReceive('email')->once();

        $container->set(UsersRepository::class, $repository);

        $request = $this->createRequest('POST', '/session/login')->withParsedBody([
            'email' => 'asjh', 'password' => 'asjh'
        ]);

        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUserLoginThrowsNotFound(): void
    {
        $this->expectException(HttpNotFoundException::class);
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(UsersRepository::class);

        $repository->shouldReceive('findByEmailAndPassword')->once()->andThrow(UserNotFound::class);

        $container->set(UsersRepository::class, $repository);

        $request = $this->createRequest('POST', '/session/login')->withParsedBody([
            'email' => 'asjh', 'password' => 'asjh'
        ]);

        $app->handle($request);
    }
}
