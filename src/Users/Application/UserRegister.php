<?php

namespace App\Users\Application;

use App\Users\Domain\Exception\UserAlreadyExists;
use App\Users\Domain\User;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;

/*
 * Registra un nuevo usuario en el sistema siempre y cuando no exista ya un usuario con el mismo email.
 * */
class UserRegister extends UserAction
{
    /**
     * @OA\Post(
     *     path="/session/register",
     *     tags={"Session"},
     *     summary="Registra un nuevo usuario en la base de datos.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos necesarios para registrar un nuevo usuario",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"email", "firstName", "lastName", "password"},
     *                 @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      format="email",
     *                      description="Correo electrónico del usuario"
     *                 ),
     *                 @OA\Property(property="firstName", type="string", description="Nombre del usuario"),
     *                 @OA\Property(property="lastName", type="string", description="Apellido del usuario"),
     *                 @OA\Property(property="password", type="string", description="Contraseña del usuario")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Operación exitosa"),
     *     @OA\Response(response="400", description="Faltan parámetros en la solicitud"),
     *     @OA\Response(response="409", description="Ya existe un usuario con el mismo correo electrónico")
     * )
     */
    protected function action(): Response
    {
        $data = $this->getFormData();
        $email = $data['email'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $password = $data['password'];
        $this->ensureEmailIsUnique($email);
        $user = new User($email, $firstName, $lastName, hash('sha256', $password), []);
        $this->repository->save($user);

        return $this->respondWithData();
    }

    /**
     * @throws UserAlreadyExists
     */
    private function ensureEmailIsUnique(string $email): void
    {
        $user = $this->repository->findByEmail($email);
        if (null !== $user) {
            throw new UserAlreadyExists();
        }
    }
}
