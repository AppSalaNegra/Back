<?php

namespace App\Events\Domain;

use App\Shared\Domain\DomainException\DomainRecordNotFoundException;

class EventNotFound extends DomainRecordNotFoundException
{
    public $message = 'The event you requested does not exist.';
}