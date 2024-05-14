<?php

namespace App\Events\Domain\Exception;

use Exception;

/*
 * Excepción que controla posible error al codificar un evento
 */

class EventEncodeFailed extends Exception
{
    protected $message = 'Event encode failed';
}
