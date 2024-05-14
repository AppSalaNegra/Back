<?php

declare(strict_types=1);

namespace App\Users\Domain\Exception;

use Slim\Exception\HttpUnauthorizedException;

final class InvalidUserCredentials extends HttpUnauthorizedException
{
    protected $message = 'invalid e-mail or username';
}
