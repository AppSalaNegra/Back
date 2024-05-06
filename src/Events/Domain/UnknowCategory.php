<?php

namespace App\Events\Domain;

use App\Shared\Domain\DomainException\DomainRecordNotFoundException;
use Slim\Exception\HttpBadRequestException;

/*
 * Excepción para cuando se intenta crear un evento con una categoria desconocida
*/

class UnknowCategory extends HttpBadRequestException
{
    protected $message = "Bad request: The category provided is unknown";
}
