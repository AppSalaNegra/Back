<?php

namespace App\Events\Domain\Exception;

use App\Shared\Domain\DomainException\DomainRecordNotFound;

/*
 * Exception thrown when an event is not found.
*/

class EventNotFound extends DomainRecordNotFound
{
    public $message = 'The event you requested does not exist.';
}
