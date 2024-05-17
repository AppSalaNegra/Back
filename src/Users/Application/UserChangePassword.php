<?php

namespace App\Users\Application;

use App\Users\Domain\Exception\UserNotFound;
use App\Users\Domain\FindUserById;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;
use Slim\Exception\HttpBadRequestException;

/*
 * Endpoint para cambio de contraseña de un usuario.
 * Primero valida que el usuario exista y que la contraseña actual sea correcta.
 * */

class UserChangePassword extends UserAction
{
    /**
     * @OA\Post(
     *     path="/users/changePassword",
     *     tags={"Users"},
     *     summary="Cambia la contraseña del usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos necesarios para cambiar la contraseña del user. Se presupone que el Id es correcto",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"id", "password", "newPassword"},
     *                 @OA\Property(property="id", type="string", format="uuid", description="ID del usuario"),
     *                 @OA\Property(property="password", type="string", description="Contraseña actual del usuario"),
     *                 @OA\Property(property="newPassword", type="string", description="Nueva contraseña del usuario")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Contraseña cambiada exitosamente"),
     *     @OA\Response(response="404", description="Usuario no encontrado, la contraseña actual es incorrecta."),
     *     @OA\Response(response="400", description="Faltan parámetros en la solicitud")
     * )
     */
    public function __construct(UsersRepository $repository, private readonly FindUserById $finder)
    {
        parent::__construct($repository);
    }

    protected function action(): Response
    {
        $data = $this->getFormData();
        $this->validateInput($data);

        $userId = $data['id'];
        $password = hash('sha256', $data['password']);
        $newPassword = $data['newPassword'];

        $email = $this->finder->findUserById($userId)->email();
        $user = $this->repository->findByEmailAndPassword($email, $password);
        if (null === $user) {
            throw new UserNotFound();
        }
        $user->changePassword(hash('sha256', $newPassword));
        $this->repository->save($user);
        return $this->respondWithData();
    }

    public function validateInput(array|null|object $data): void
    {
        if (empty($data['id']) || empty($data['password']) || empty($data['newPassword'])) {
            throw new HttpBadRequestException($this->request);
        }
    }
}
