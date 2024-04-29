<?php

declare(strict_types=1);

use App\Events\Application\GetAllEventsAction;
use App\Events\Application\StoreParentEvents;
use App\Events\Application\StoreUpcomingEvents;
use App\Posts\Application\GetAllPostsAction;
use App\Posts\Application\StorePosts;
use App\Shared\Application\Middleware\AuthMiddleware;
use App\Users\Application\Login\UserLoginAction;
use App\Users\Application\UserDislikeEvent;
use App\Users\Application\UserLikeEvent;
use App\Users\Application\UserGetLikedShowsAction;
use App\Users\Application\UserRegisterAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });

    $app->group('/posts', function (Group $group) {
        $group->put('/store', StorePosts::class);
        $group->get('/get', GetAllPostsAction::class)->addMiddleware(new AuthMiddleware());
    });

    $app->group('/events', function (Group $group) {
        $group->put('/storeUpcoming', StoreUpcomingEvents::class);
        $group->put('/storeParents', StoreParentEvents::class);
        $group->get('/get', GetAllEventsAction::class);
    });

    $app->group('/users', function (Group $group) {
        $group->post('/login', UserLoginAction::class);
        $group->post('/register', UserRegisterAction::class);
        $group->get('/get-liked-shows', UserGetLikedShowsAction::class);
        $group->put('/like', UserLikeEvent::class);
        $group->put('/dislike', UserDislikeEvent::class);
    });
};
