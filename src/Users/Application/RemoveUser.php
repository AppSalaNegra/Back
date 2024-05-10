<?php

namespace App\Users\Application;

use App\Users\Domain\FindUserById;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;

/*
 * Caso de uso "Eliminar usuario". Elimina un usuario de la base de datos.
 */
class RemoveUser extends UserAction
{
    /**
     * @OA\Put(
     *     path="/users/remove",
     *     tags={"Users"},
     *     summary="Elimina un usuario de la base de datos.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos necesarios para eliminar un usuario",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"id"},
     *                 @OA\Property(
     *                      property="id",
     *                      type="string",
     *                      format="uuid",
     *                      description="ID del usuario a eliminar"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Operación exitosa"),
     *     @OA\Response(response="404", description="Usuario no encontrado"),
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
        $userId = $data['id'];
        $user = $this->finder->findUserById($userId);
        $this->repository->remove($user);
        return $this->respondWithData();
    }
}
