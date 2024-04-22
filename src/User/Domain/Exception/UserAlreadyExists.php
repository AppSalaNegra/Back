<?php

namespace App\User\Domain\Exception;

use App\Shared\Domain\DomainException\DomainRecordNotFoundException;

class UserAlreadyExists extends DomainRecordNotFoundException
{
    public $message = 'That email is already registered.';
}
