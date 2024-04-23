<?php

declare(strict_types=1);

namespace App\User\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;

abstract class UserGetLikedShowsAction extends UserAction
{
    protected UserRepository $userRepository;

    public function __construct(LoggerInterface $logger, UserRepository $userRepository)
    {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
    }
}