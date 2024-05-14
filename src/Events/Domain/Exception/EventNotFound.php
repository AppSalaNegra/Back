<?php

namespace App\Events\Domain\Exception;

use App\Shared\Domain\DomainException\DomainRecordNotFoundException;

/*
 * Exception thrown when an event is not found.
*/

class EventNotFound extends DomainRecordNotFoundException
{
    public $message = 'The event you requested does not exist.';
}
