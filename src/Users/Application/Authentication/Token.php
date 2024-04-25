<?php

declare(strict_types=1);

namespace App\Users\Application\Authentication;

use App\Users\Domain\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
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
            'exp' => time() + 1800 //getenv('JWT_EXP') ?? 3600,
        ];

        return JWT::encode($payload, Token::getSecret(), 'HS256');
    }

    /**
     * @throws NoTokenProvided
     * @throws InvalidToken
     */
    public static function validateToken(Request $request): Request
    {
        $token = self::getTokenFromHeader($request);
        if ($token) {
            try {
                $decoded = JWT::decode($token, new Key(self::getSecret(), 'HS256'));
                // TODO: investigate about this:
                return $request->withAttribute('jwt_payload', (array) $decoded);
            } catch (Exception $e) {
                throw new InvalidToken('Invalid Token: ' . $e->getMessage());
            }
        } else {
            throw new NoTokenProvided();
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
