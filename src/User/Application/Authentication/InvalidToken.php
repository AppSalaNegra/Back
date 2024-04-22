<?php

declare(strict_types=1);

namespace App\User\Application\Authentication;

use Exception;

final class InvalidToken extends Exception
{
    public $message = 'Provided token is invalid.';
    public $code = 401;
}
