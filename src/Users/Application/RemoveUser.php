<?php

namespace App\Users\Application;

use App\Users\Domain\FindUserById;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

/*
 * Caso de uso "Eliminar usuario". Elimina un usuario de la base de datos.
 */

class RemoveUser extends UserAction
{
    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Elimina un usuario de la base de datos.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *        name="id",
     *        in="path",
     *        description="Id del usuario",
     *        required=true,
     *        @OA\Schema(
     *            type="string",
     *            format="uuid"
     *        )
     *     ),
     *     @OA\Response(response="200", description="Operación exitosa"),
     *     @OA\Response(response="404", description="Usuario no encontrado"),
     *     @OA\Response(response="400", description="Bad request.")
     * )
     */
    public function __construct(UsersRepository $repository, private readonly FindUserById $finder)
    {
        parent::__construct($repository);
    }

    protected function action(): Response
    {
        $data   = $this->getFormData();
        $userId = $data['id'];
        $user   = $this->finder->findUserById($userId);
        $this->repository->remove($user);
        return $this->respondWithData();
    }

    public function validateInput(array|null|object $data): void
    {
        if (empty($data['id'])) {
            throw new HttpBadRequestException($this->request);
        }
    }
}
