<?php

declare(strict_types=1);

use App\Events\Application\GetAllEvents;
use App\Events\Application\GetEventsByCat;
use App\Events\Application\StoreParentEvents;
use App\Events\Application\StoreUpcomingEvents;
use App\Posts\Application\GetAllPosts;
use App\Posts\Application\StorePosts;
use App\Shared\Application\Middleware\AuthMiddleware;
use App\Users\Application\Authentication\Token;
use App\Users\Application\Login\UserLogin;
use App\Users\Application\UserDislikeEvent;
use App\Users\Application\UserLikeEvent;
use App\Users\Application\UserGetLikedEvents;
use App\Users\Application\UserRegister;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });

    $app->group('/store', function (Group $group) {
        $group->put('/posts', StorePosts::class);
        $group->put('/upcomingEvents', StoreUpcomingEvents::class);
        $group->put('/parentEvents', StoreParentEvents::class);
    });

    $app->group('/session', function (Group $group) {
        $group->post('/login', UserLogin::class);
        $group->post('/register', UserRegister::class);
    });

    $app->get('/posts', GetAllPosts::class);

    $app->group('/events', function (Group $group) {
        $group->get('/get', GetAllEvents::class);
        $group->get('/getByCat', GetEventsByCat::class);
    });

    $app->group('/users', function (Group $group) {
        $group->get('/getLikedShows', UserGetLikedEvents::class);
        $group->put('/like', UserLikeEvent::class);
        $group->put('/dislike', UserDislikeEvent::class);
    });
};
