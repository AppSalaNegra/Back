<?php

namespace App\Posts\Domain;

use Exception;

/*
 * Excepción que se lanza cuando falla la codificación de un post
 * */
class PostEncodeFailed extends Exception
{
    protected $message = 'Post encode failed';
}