<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\DomainException\DomainException;

class UserAlreadyExists extends DomainException
{
    public $message = 'The email provided is already registered.';
}
