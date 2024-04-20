<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\JWT;

use App\User\Domain\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface;

final class Token
{
    /**
     * Get the secret key
     *
     * @return string
     */
    private static function getSecret(): string
    {
        return getenv('JWT_SECRET') ?: 'default_secret';
    }

    /**
     * Create a new token
     *
     * @param User $user
     * @return string
     */
    public static function createToken(User $user): string
    {
        $exp = getenv('JWT_EXP') ?: 3600;
        $payload = [
            'iss' => "your_issuer",
            'aud' => "your_audience",
            'iat' => time(),
            'exp' => time() + $exp,
        ];

        return JWT::encode($payload, Token::getSecret(), 'HS256');
    }

    /**
     * Validate a token
     *
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     * @throws InvalidToken
     */
    public static function validateToken(ServerRequestInterface $request): ServerRequestInterface
    {
        $authorizationHeader = $request->getHeaderLine('Authorization');

        // Check if the authorization header is present and has the expected format
        if (empty($authorizationHeader) || !preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            throw new Exception('Token not found or invalid');
        }

        $token = $matches[1]; // Extracts the token from the header.

        try {
            $decoded = JWT::decode($token, new Key(Token::getSecret(), 'HS256'));
        } catch (Exception $e) {
            throw new InvalidToken();
        }

        // Si el token es válido, adjunta la información decodificada a la solicitud para su uso posterior.
        return $request->withAttribute('token', $decoded);
    }
}