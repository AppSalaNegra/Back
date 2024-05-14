<?php

declare(strict_types=1);

use App\Events\Domain\EventsRepository;
use App\Events\Infrastructure\DoctrineEventsRepository;
use App\Posts\Domain\PostsRepository;
use App\Posts\Infrastructure\DoctrinePostsRepository;
use App\Users\Domain\UsersRepository;
use App\Users\Infrastructure\DoctrineUsersRepository;
use DI\ContainerBuilder;

use function DI\autowire;

/*
 * Aquí se registran los repositorios de la aplicación y sus respectivas implementaciones.
 * */
return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions(
        [
            UsersRepository::class => autowire(DoctrineUsersRepository::class),
            EventsRepository::class => autowire(DoctrineEventsRepository::class),
            PostsRepository::class => autowire(DoctrinePostsRepository::class)
        ]
    );
};
