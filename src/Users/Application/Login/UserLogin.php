<?php

namespace App\Users\Application\Login;

use App\Users\Application\Authentication\Token;
use App\Users\Application\UserAction;
use App\Users\Domain\Exception\InvalidUserCredentials;
use App\Users\Domain\Exception\UserNotFound;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;

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
     *     @OA\RequestBody(
     *     required=true,
     *     description="Datos necesarios para loggear en la app",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             required={"email", "firstName", "lastName", "password"},
     *             @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  format="email",
     *                  description="Correo electrónico del usuario"
     *             ),
     *             @OA\Property(property="password", type="string", description="Contraseña del usuario")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *       response="200",
     *       description="Operación exitosa, devuelve un Token JWT y userId",
     *       @OA\JsonContent(
     *           @OA\Examples(
     *               example="0",
     *               summary="Log in exitoso!",
     *                   value={
     *                   {
     *                       "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c",
     *                       "id": "3fa85f64-5717-4562-b3fc-2c963f66afa6",
     *                   }
     *               }
     *           ),
     *       )
     *    ),
     * )
     */
    public function __construct(UsersRepository $repository, private readonly Token $token)
    {
        parent::__construct($repository);
    }

    protected function action(): Response
    {
        $data = $this->getFormData();
        $email = $data['email'];
        $password = hash('sha256', $data['password']);
        $user = $this->repository->findByEmailAndPassword($email, $password);
        if (null === $user) {
            throw new InvalidUserCredentials($this->request);
        }
        $token = $this->token->createToken($user);
        return $this->respondWithData(['token' => $token, 'id' => $user->id()]);
    }
}
