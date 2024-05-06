<?php

namespace Tests\Users;

use App\Shared\Application\Actions\ActionPayload;
use App\Users\Domain\FindUserById;
use App\Users\Domain\User;
use App\Users\Domain\UsersRepository;
use Firebase\JWT\JWT;
use Mockery;
use Tests\TestCase;

class UserChangePasswordTest extends TestCase
{
    public function testItShouldChangePassword(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $repository = Mockery::mock(UsersRepository::class);
        $userFinder = Mockery::mock(FindUserById::class);
        $user = Mockery::mock(User::class);
        $jwt = JWT::encode([], 'secret', 'HS256');

        $userFinder->shouldReceive('findById')->once();
        $repository->shouldReceive('findById')->once()->andReturn($user);
        $user->shouldReceive('email')->once()->andReturn('email');
        $repository->shouldReceive('findByEmailAndPassword')->once()->andReturn($user);
        $user->shouldReceive('changePassword')->once();
        $repository->shouldReceive('save')->once();

        $container->set(UsersRepository::class, $repository);

        $request = $this->createRequest('POST', '/users/changePassword')
            ->withParsedBody([
                'id' => 'userId',
                'password' => 'password',
                'newPassword' => 'newPassword',
            ])
            ->withHeader('Authorization', 'Bearer ' . $jwt);

        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}