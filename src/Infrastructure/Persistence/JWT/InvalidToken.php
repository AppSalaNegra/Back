<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\JWT;

use Exception;

final class InvalidToken extends Exception
{
    public $message = 'Provided token is invalid.';
}
