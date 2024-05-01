<?php

namespace App\Events\Domain;

use App\Shared\Domain\DomainException\DomainRecordNotFoundException;
use Slim\Exception\HttpBadRequestException;

class UnknowCategory extends HttpBadRequestException
{
    protected $message = "Bad request: The category provided is unknown";
}
