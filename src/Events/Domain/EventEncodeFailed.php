<?php

namespace App\Events\Domain;

use Exception;
use Throwable;

/*
 * Excepción que controla posible error al codificar un evento
 */

class EventEncodeFailed extends Exception
{
    protected $message = 'Event encode failed';
}
