<?php

declare(strict_types=1);

namespace App\Users\Application;

use App\Users\Domain\FindUserById;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

/**
 * @OA\Post(
 *     path="/users/update",
 *     tags={"Users"},
 *     summary="Actualiza la lista de eventos del usuario",
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos necesarios para actualizar el usuario",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"events"},
 *                 @OA\Property(property="id", type="string", format="uuid", description="ID del usuario"),
 *                 @OA\Property(
 *                     property="events",
 *                     type="array",
 *                     description="Lista de eventos",
 *                     @OA\Items(
 *                         type="string",
 *                     )
 *                 ),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Operación exitosa"),
 *     @OA\Response(response="404", description="Usuario no encontrado"),
 *     @OA\Response(response="400", description="Bad request.")
 * )
 */

final class UpdateUserEvents extends UserAction
{
    public function __construct(
        UsersRepository $repository,
        private readonly FindUserById $userFinder
    ) {
        parent::__construct($repository);
    }

    protected function action(): Response
    {
        $data = $this->getFormData();
        $this->validateInput($data);
        $id     = $data['id'];
        $events = json_decode($data['events']);
        var_dump($events);
        $user   = $this->userFinder->findUserById($id);
        $user->updateEvents($events);
        $this->repository->save($user);
        return $this->respondWithData();
    }

    public function validateInput(array|null|object $data): void
    {
        if (empty($data['id']) || empty($data['events'])) {
            throw new HttpBadRequestException($this->request);
        }
    }
}
