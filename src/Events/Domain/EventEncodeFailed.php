<?php

namespace App\Events\Domain;

use Exception;
use Throwable;

class EventEncodeFailed extends Exception
{
    protected $message = 'Event encode failed';
}
