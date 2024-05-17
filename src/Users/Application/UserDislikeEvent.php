<?php

namespace App\Users\Application;

use App\Events\Application\FindEventById;
use App\Users\Domain\FindUserById;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;
use Slim\Exception\HttpBadRequestException;

/*
 * Endpoint para cuando un usuario pulsa el botón de dislike en un evento.
 * Se elimina dicho evento de la lista de eventos del usuario.
 * */
final class UserDislikeEvent extends UserAction
{
    /**
     * @OA\Put(
     *     path="/users/dislike",
     *     tags={"Users"},
     *     summary="Elimina un evento de la lista de eventos gustados del usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos necesarios para eliminar un evento de la lista de eventos gustados del usuario",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"id", "eventId"},
     *                 @OA\Property(property="id", type="string", format="uuid", description="ID del usuario"),
     *                 @OA\Property(
     *                      property="eventId", type="string", format="uuid",
     *                      description="ID del evento a eliminar de la lista de eventos gustados del usuario"
     *                  )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Operación exitosa"),
     *     @OA\Response(response="404", description="Usuario o evento no encontrado"),
     *     @OA\Response(response="400", description="Faltan parámetros en la solicitud")
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
        $userId = $data['id'];
        $eventId = $data['eventId'];

        $user = $this->userFinder->findUserById($userId);
        $this->eventFinder->findEventById($eventId);
        $user->removeLikedEvent($eventId);
        $this->repository->save($user);
        return $this->respondWithData();
    }

    public function validateInput(array|null|object $data): void
    {
        if (empty($data['id']) || empty($data['eventId'])) {
            throw new HttpBadRequestException($this->request);
        }
    }
}
