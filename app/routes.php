<?php

declare(strict_types=1);

use App\Events\Application\GetAllEvents;
use App\Events\Application\GetEventsByCat;
use App\Events\Application\StoreParentEvents;
use App\Events\Application\StoreUpcomingEvents;
use App\Posts\Application\GetAllPosts;
use App\Posts\Application\StorePosts;
use App\Shared\Application\Middleware\AuthMiddleware;
use App\Users\Application\Login\UserLogin;
use App\Users\Application\RemoveUser;
use App\Users\Application\UserChangePassword;
use App\Users\Application\UserDislikeEvent;
use App\Users\Application\UserLikeEvent;
use App\Users\Application\UserGetLikedEvents;
use App\Users\Application\UserRegister;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

/*
 * Este es el corazón de la aplicación, aquí se definen las rutas de la API,
 * las acciones que se ejecutarán en cada una de ellas y los middlewares que se aplicarán a cada una de ellas.
 * */

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

    $app->get('/posts', GetAllPosts::class)->add(AuthMiddleware::class);

    $app->group('/events', function (Group $group) {
        $group->get('/get', GetAllEvents::class);
        $group->get('/getByCat', GetEventsByCat::class);
    })->add(AuthMiddleware::class);

    $app->group('/users', function (Group $group) {
        $group->get('/getLikedEvents', UserGetLikedEvents::class);
        $group->put('/like', UserLikeEvent::class);
        $group->put('/dislike', UserDislikeEvent::class);
        $group->post('/changePassword', UserChangePassword::class);
        $group->put('/remove', RemoveUser::class);
    })->add(AuthMiddleware::class);
};
