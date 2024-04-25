<?php

namespace App\Users\Application\Authentication;

use Exception;

class NoTokenProvided extends Exception
{
    public $message = 'No jwt token provided.';
    public $code = 401;
}
