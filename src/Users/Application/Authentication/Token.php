<?php

declare(strict_types=1);

namespace App\Users\Application\Authentication;

use App\Users\Domain\Exception\InvalidToken;
use App\Users\Domain\Exception\NoTokenProvided;
use App\Users\Domain\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface as Request;

/*
 * Clase que incluye lógica para la creación y validación de tokens JWT
*/
class Token
{
    //Obtiene la clave secreta para firmar los tokens
    private function getSecret(): string
    {
        return getenv('JWT_SECRET') ?: 'secret';
    }

    //Crea un token JWT a partir de un usuario
    public function createToken(User $user): string
    {
        $payload = [
            'sub' => $user->id(),
            'email' => $user->email(),
            'iat' => time(),
            'exp' => time() + 1800 //getenv('JWT_EXP') ?? 3600,
        ];

        return JWT::encode($payload, Token::getSecret(), 'HS256');
    }

    /**
     * @throws NoTokenProvided
     * @throws InvalidToken
     * Validar un token JWT a partir de una petición HTTP
     */
    public function validateToken(Request $request): Request
    {
        $token = self::getTokenFromHeader($request);
        if ($token) {
            try {
                $decoded = JWT::decode($token, new Key(self::getSecret(), 'HS256'));
                return $request->withAttribute('jwt_payload', (array) $decoded);
            } catch (Exception) {
                throw new InvalidToken($request);
            }
        } else {
            throw new NoTokenProvided($request);
        }
    }

    //Obtiene el token de la cabecera de la petición
    private function getTokenFromHeader(Request $request): ?string
    {
        $header = $request->getHeaderLine('Authorization');
        if (preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
