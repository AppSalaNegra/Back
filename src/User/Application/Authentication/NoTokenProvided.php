<?php

namespace App\User\Application\Authentication;

use Exception;

class NoTokenProvided extends Exception
{
    public $message = 'No jwt token provided.';
    public $code = 401;
}
