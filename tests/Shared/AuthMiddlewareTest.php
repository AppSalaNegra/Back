<?php

namespace Tests\Shared;

use App\Shared\Application\Middleware\AuthMiddleware;
use App\Users\Application\Authentication\Token;
use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Tests\TestCase;

class AuthMiddlewareTest extends TestCase
{
    public function testProcessReturnsUnauthorizedResponseWhenTokenValidationFails(): void
    {

    }
}