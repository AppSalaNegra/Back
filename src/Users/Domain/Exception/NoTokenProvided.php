<?php

namespace App\Users\Domain\Exception;

use Slim\Exception\HttpUnauthorizedException;

class NoTokenProvided extends HttpUnauthorizedException
{
    public $message = 'No jwt token provided.';
    public $code = 401;
}
