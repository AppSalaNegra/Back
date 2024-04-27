<?php

declare(strict_types=1);

namespace App\Users\Application;

use App\Shared\Application\Actions\Action;
use App\Users\Domain\UserRepository;

abstract class UserAction extends Action
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
}
