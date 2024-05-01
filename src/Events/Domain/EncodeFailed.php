<?php

namespace App\Events\Domain;

use Exception;
use Throwable;

class EncodeFailed extends Exception
{
    public function __construct(
        string $message = 'Error occurred during encoding',
        int $statusCode = 500,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode, $previous);
    }
}
