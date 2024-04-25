<?php

declare(strict_types=1);

use App\Events\Domain\EventsRepository;
use App\Events\Infrastructure\DoctrineEventsRepository;
use App\Posts\Domain\PostsRepository;
use App\Posts\Infrastructure\DoctrinePostsRepository;
use App\Users\Domain\UserRepository;
use App\Users\Infrastructure\DoctrineUserRepository;
use DI\ContainerBuilder;

use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions(
        [
            UserRepository::class => autowire(DoctrineUserRepository::class),
            EventsRepository::class => autowire(DoctrineEventsRepository::class),
            PostsRepository::class => autowire(DoctrinePostsRepository::class)
        ]
    );
};
