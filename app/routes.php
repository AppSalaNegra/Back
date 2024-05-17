<?php

declare(strict_types=1);

use App\Events\Application\GetEventsByCat;
use App\Events\Application\GetEventsFromToday;
use App\Posts\Application\GetAllPosts;
use App\Shared\Infrastructure\Middleware\AuthMiddleware;
use App\Shared\Infrastructure\Swagger\Swagger;
use App\Users\Application\Login\UserLogin;
use App\Users\Application\RemoveUser;
use App\Users\Application\UserChangePassword;
use App\Users\Application\UserDislikeEvent;
use App\Users\Application\UserGetLikedEvents;
use App\Users\Application\UserLikeEvent;
use App\Users\Application\UserRegister;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });

    $app->group('/session', function (Group $group) {
        $group->post('/login', UserLogin::class);
        $group->post('/register', UserRegister::class);
    });

    $app->get('/posts', GetAllPosts::class)->add(AuthMiddleware::class);

    $app->group('/events', function (Group $group) {
        $group->get('/get', GetEventsFromToday::class);
        $group->get('/getByCat', GetEventsByCat::class);
    })->add(AuthMiddleware::class);

    $app->group('/users', function (Group $group) {
        $group->get('/getLikedEvents', UserGetLikedEvents::class);
        $group->put('/like', UserLikeEvent::class);
        $group->put('/dislike', UserDislikeEvent::class);
        $group->post('/changePassword', UserChangePassword::class);
        $group->delete('/remove', RemoveUser::class);
    })->add(AuthMiddleware::class);

    $app->get('/swagger', function (Request $request, Response $response) {
        $serverUrl = $request->getUri()->getScheme() . '://' . $request->getUri()->getHost();
        $serverUrl .= $request->getUri()->getPort() ? ':' . $request->getUri()->getPort() : '';

        $swagger = new Swagger(
            $serverUrl,
            'Local server',
            __DIR__ . '/../openapi.json'
        );

        $response = $response->withHeader('Content-Type', 'text/html');
        $response->getBody()->write($swagger->get());
        return $response;
    });
};
