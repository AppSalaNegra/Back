<?php

declare(strict_types=1);

namespace App\Users\Domain\Exception;

use Slim\Exception\HttpSpecializedException;

class HttpConflict extends HttpSpecializedException
{
    protected $code = 409;
}
