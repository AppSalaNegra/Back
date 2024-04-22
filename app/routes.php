<?php

declare(strict_types=1);

use App\User\Application\Actions\UserLoginAction;
use App\User\Application\Actions\UserRegisterAction;
use App\User\Application\Actions\UsersListAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/user', function (Group $group) {
        $group->post('/login', UserLoginAction::class);
        $group->post('/register', UserRegisterAction::class);
    });

    $app->get('/test', function (Request $request, Response $response) {
        $response->getBody()->write('prueba');
        return $response;
    });
};
