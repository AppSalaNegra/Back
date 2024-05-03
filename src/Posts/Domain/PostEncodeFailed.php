<?php

namespace App\Posts\Domain;

use Exception;

class PostEncodeFailed extends Exception
{
    protected $message = 'Post encode failed';
}