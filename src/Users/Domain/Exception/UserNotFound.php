<?php

declare(strict_types=1);

namespace App\Users\Domain\Exception;

use App\Shared\Domain\DomainException\DomainRecordNotFound;

class UserNotFound extends DomainRecordNotFound
{
    public $message = 'The user you requested does not exist.';
}
