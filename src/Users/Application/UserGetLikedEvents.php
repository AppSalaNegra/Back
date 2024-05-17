<?php

declare(strict_types=1);

namespace App\Users\Application;

/*
 *  Devuelve la lista de eventos que le han gustado a un usuario.
 * */

use App\Events\Application\FindEventById;
use App\Users\Domain\FindUserById;
use App\Users\Domain\User;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;
use Slim\Exception\HttpBadRequestException;

final class UserGetLikedEvents extends UserAction
{
    /**
     * @OA\Get(
     *     path="/users/getLikedEvents",
     *     tags={"Users"},
     *     summary="Devuelve una lista de eventos que le gustan al usuario que envía la petición",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos necesarios para eliminar un evento de la lista de eventos gustados del usuario",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"id"},
     *                 @OA\Property(property="id", type="string", format="uuid", description="ID del usuario"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Lista de eventos que le han gustado al usuario",
     *         @OA\JsonContent(
     *             @OA\Examples(
     *                 example="0",
     *                 summary="Encontrados eventos!",
     *                 value={
     *                     {
     *                         "id": "3fa85f64-5717-4562-b3fc-2c963f66afa6",
     *                         "startDateTime": "dateTime",
     *                         "finishDateTime": "dateTime",
     *                         "title": "string",
     *                         "excerpt": "string",
     *                         "url": "string",
     *                         "slug": "string",
     *                         "thumbnail_url": "string",
     *                         "cats": "collection",
     *                         "status": "string",
     *                         "hierarchy": "string",
     *                         "type": "string"
     *                     }
     *                 }
     *             ),
     *             @OA\Examples(
     *                 example="1",
     *                 summary="No se encontraron eventos",
     *                 value={}
     *             )
     *         )
     *     ),
     *     @OA\Response(response="400", description="Bad request."),
     *     @OA\Response(response="404", description="Usuario no encontrado"),
     * )
     */
    public function __construct(
        UsersRepository $repository,
        private readonly FindEventById $eventFinder,
        private readonly FindUserById $userFinder
    ) {
        parent::__construct($repository);
    }

    protected function action(): Response
    {
        $data = $this->getFormData();
        $this->validateInput($data);
        $id = $data['id'];
        $user = $this->userFinder->findUserById($id);
        return $this->respondWithData($this->getAllUserEvents($user));
    }

    private function getAllUserEvents(User $user): array
    {
        $likedEvents = $user->likedEvents();
        if (empty($likedEvents)) {
            return [];
        }
        return array_map(function ($eventId) {
            $event = $this->eventFinder->findEventById($eventId);
            return $event->jsonSerialize();
        }, $likedEvents);
    }

    public function validateInput(array|null|object $data): void
    {
        if (empty($data['id'])) {
            throw new HttpBadRequestException($this->request);
        }
    }
}
