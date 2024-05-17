<?php

namespace App\Shared\Infrastructure\Middleware;

use App\Users\Application\Authentication\Token;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/*
 * Middleware de autentificación. Se encarga de validar el token de autentificación proporcionado por el cliente.
 * Si el token es válido, se permite el acceso a la ruta solicitada. En caso contrario, se devuelve un mensaje de error.
 * */

class AuthMiddleware implements Middleware
{
    public function __construct(private readonly Token $token)
    {
    }

    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        $request = $this->token->validateToken($request);
        return $handler->handle($request);
    }
}
