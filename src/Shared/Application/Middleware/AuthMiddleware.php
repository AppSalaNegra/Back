<?php

namespace App\Shared\Application\Middleware;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthMiddleware implements Middleware
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $token = $this->getTokenFromHeader($request);
        if ($token) {
            try {
                $decoded = JWT::decode($token, $this->jwtSecret, ['HS256']);
                // Aquí puedes realizar cualquier validación adicional del token si es necesario
                $request = $request->withAttribute('session', $decoded);
            } catch (\Exception $e) {
                // Manejo de errores si el token es inválido
                // Puedes devolver una respuesta de error 401 Unauthorized aquí
            }
        }

        return $handler->handle($request);
    }
    private function getTokenFromHeader(Request $request): ?string
    {
        $header = $request->getHeaderLine('Authorization');
        if (preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
