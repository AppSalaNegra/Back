<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);
};
