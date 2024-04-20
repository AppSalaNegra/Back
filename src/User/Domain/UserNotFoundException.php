<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\Shared\Domain\DomainException\DomainRecordNotFoundException;

class UserNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The user you requested does not exist.';
}
