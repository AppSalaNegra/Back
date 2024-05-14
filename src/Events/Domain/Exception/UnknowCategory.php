<?php

namespace App\Events\Domain\Exception;

use Slim\Exception\HttpBadRequestException;

/*
 * Excepción para cuando se intenta crear un evento con una categoría desconocida
*/

class UnknowCategory extends HttpBadRequestException
{
    protected $message = "Bad request: The category provided is unknown";
}
