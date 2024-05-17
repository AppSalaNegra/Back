<?php

namespace App\Users\Domain\Exception;

class UserAlreadyExists extends HttpConflict
{
    public $message = 'The email provided is already registered.';
}
