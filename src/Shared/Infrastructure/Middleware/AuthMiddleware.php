<?php

namespace App\Shared\Infrastructure\Middleware;

use App\Users\Application\Authentication\Token;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

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
        $response = new Response();
        try {
            $request = $this->token->validateToken($request);
        } catch (Exception $e) {
            $response->getBody()->write(json_encode([$e->getMessage()]));
            return $response->withStatus(401);
        }
        return $handler->handle($request);
    }
}
