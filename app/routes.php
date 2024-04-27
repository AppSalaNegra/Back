<?php

declare(strict_types=1);

use App\Posts\Application\GetAllPostsAction;
use App\Shared\Application\Middleware\AuthMiddleware;
use App\Users\Application\Login\UserLoginAction;
use App\Users\Application\UserRegisterAction;
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

    $app->get('/posts', GetAllPostsAction::class)->addMiddleware(new AuthMiddleware());

    $app->group('/user', function (Group $group) {
        $group->post('/login', UserLoginAction::class);
        $group->post('/register', UserRegisterAction::class);
    });

    $app->get('/test', function (Request $request, Response $response) {
        $response->getBody()->write('prueba');
        return $response;
    })->addMiddleware(new AuthMiddleware());
};
