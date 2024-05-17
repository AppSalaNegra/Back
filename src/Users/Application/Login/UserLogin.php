<?php

namespace App\Users\Application\Login;

use App\Users\Application\Authentication\Token;
use App\Users\Application\UserAction;
use App\Users\Domain\Exception\InvalidUserCredentials;
use App\Users\Domain\Exception\UserNotFound;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;
use Slim\Exception\HttpBadRequestException;

/*
 * Endpoint para el login de usuarios. Se encarga de autenticar a un usuario y devolver un token de autenticación.
 * */

class UserLogin extends UserAction
{
    /**
     * @OA\Post(
     *     path="/session/login",
     *     tags={"Session"},
     *     summary="Inicia sesión de usuario y devuelve un Token jwt",
     *     @OA\Response(response="200", description="Operación exitosa")
     * )
     */
    public function __construct(UsersRepository $repository, private readonly Token $token)
    {
        parent::__construct($repository);
    }

    protected function action(): Response
    {
        $data = $this->getFormData();
        $this->validateInput($data);

        $email = $data['email'];
        $password = hash('sha256', $data['password']);

        $user = $this->repository->findByEmailAndPassword($email, $password);
        if (null === $user) {
            throw new InvalidUserCredentials($this->request);
        }
        $token = $this->token->createToken($user);
        return $this->respondWithData(['token' => $token, 'id' => $user->id()]);
    }

    public function validateInput(array|null|object $data): void
    {
        if (empty($data['email']) || empty($data['password'])) {
            throw new HttpBadRequestException($this->request);
        }
    }
}
