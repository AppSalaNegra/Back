<?php

declare(strict_types=1);

namespace App\Users\Domain\Exception;

use Slim\Exception\HttpUnauthorizedException;

/*
 * Excepción que se lanza cuando el token JWT proporcionado no es válido.
*/
final class InvalidToken extends HttpUnauthorizedException
{
    public $message = 'Provided token is invalid.';
    public $code = 401;
}
