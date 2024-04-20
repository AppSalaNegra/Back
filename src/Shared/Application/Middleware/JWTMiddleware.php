<?php

namespace App\Shared\Application\Middleware;

use App\Infrastructure\Persistence\JWT\InvalidToken;
use App\Infrastructure\Persistence\JWT\Token;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class JWTMiddleware implements MiddlewareInterface
{
    // Array de permisos requeridos para acceder a la ruta.
    private array $requiredPermissions;

    // Constructor que opcionalmente acepta un array de permisos requeridos.
    public function __construct(array $requiredPermissions = [])
    {
        $this->requiredPermissions = $requiredPermissions;
    }

    // Método requerido por la interfaz Middleware que procesa la solicitud.
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            // Validates the token and attaches it to the request as an attribute.
            $request = Token::validateToken($request);
            if (!$this->checkPermissions($request)) { // Returns a response with HTTP 403 Forbidden status.
                $response = new Response();
                $response->getBody()->write(json_encode(['error' => 'Insufficient permissions']));
                return $response->withStatus(403)->withHeader('Content-Type', 'application/json');
            }
        } catch (InvalidToken $e) { // Returns a response with HTTP 401 Unauthorized status.
            $response = new Response();
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
        return $handler->handle($request); // If the token is valid, process the next middleware layer or the route.
    }

    /*
     * This method checks if the token has the required permissions.
     *
     * @param ServerRequestInterface $request The request object.
     * @return bool True if the token has the required permissions, false otherwise.
     * @throws InvalidTokenException If the token is invalid.
     */
    private function checkPermissions(ServerRequestInterface $request): bool
    {
        $decodedToken = $request->getAttribute('token');
        if (!empty($this->requiredPermissions)) {
            $tokenPermissions = $decodedToken->per ?? [];
            $hasPermission    = false;
            foreach ($this->requiredPermissions as $requiredPermission) {
                if (in_array($requiredPermission, $tokenPermissions)) {
                    $hasPermission = true;
                    break;
                }
            }
            return $hasPermission;
        }
        return true;
    }
}
