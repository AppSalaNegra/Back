<?php

namespace App\Shared\Infrastructure;

use Exception;

class ActuaApiFailed extends Exception
{
    protected $message = 'Error calling public api';
}
