<?php

declare(strict_types=1);

use App\User\Domain\UserRepository;
use App\User\Infrastructure\MongoUserRepository;
use DI\ContainerBuilder;

use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in db implementation
    $containerBuilder->addDefinitions([UserRepository::class => autowire(MongoUserRepository::class),]);
};
