<?php

declare(strict_types=1);

namespace App\Users\Application;

use App\Shared\Infrastructure\Actions\Action;
use App\Users\Domain\UsersRepository;

abstract class UserAction extends Action
{
    protected UsersRepository $repository;

    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }
}
