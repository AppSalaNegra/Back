<?php

declare(strict_types=1);

namespace App\Users\Application\Authentication;

use Exception;

/*
 * Excepción que se lanza cuando el token JWT proporcionado no es válido.
*/
final class InvalidToken extends Exception
{
    public $message = 'Provided token is invalid.';
    public $code = 401;
}
