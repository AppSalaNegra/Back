<?php

declare(strict_types=1);

namespace App\User\Application\Authentication;

use App\User\Domain\User;
use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface as Request;

final class Token
{
    private static function getSecret(): string
    {
        return getenv('JWT_SECRET') ?: 'secret';
    }

    public static function createToken(User $user): string
    {
        $payload = [
            'sub' => $user->getId(),
            'email' => $user->getEmail(),
            'iat' => time(),
            'exp' => time() + getenv('JWT_EXP') ?? 3600,
        ];

        return JWT::encode($payload, Token::getSecret(), 'HS256');
    }

    public static function validateToken(Request $request): Request
    {
        $token = self::getTokenFromHeader($request);
        if ($token) {
            try {
                $decoded = JWT::decode($token, self::getSecret(), ['HS256']);
                // Si el token es válido, puedes agregar los datos decodificados como un atributo en la solicitud
                return $request->withAttribute('jwt_payload', (array) $decoded);
            } catch (\Exception $e) {
                // Manejo de errores si el token es inválido
                // Aquí puedes devolver una respuesta de error o lanzar una excepción
                throw new \Exception('Token inválido: ' . $e->getMessage());
            }
        } else {
            // Si no se proporciona un token en el encabezado de autorización, también puedes manejarlo aquí
            throw new \Exception('Token no encontrado en el encabezado de autorización');
        }
    }

    private static function getTokenFromHeader(Request $request): ?string
    {
        $header = $request->getHeaderLine('Authorization');
        if (preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            return $matches[1];
        }
        return null;
    }

}