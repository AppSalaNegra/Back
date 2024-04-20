<?php

declare(strict_types=1);

namespace App\User\Application\Actions;

use App\Shared\Application\Actions\Action;
use App\User\Domain\UserRepository;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    protected UserRepository $userRepository;

    public function __construct(LoggerInterface $logger, UserRepository $userRepository)
    {
        parent::__construct($logger);
        $this->userRepository = $userRepository;
    }
}