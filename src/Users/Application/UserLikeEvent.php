<?php

namespace App\Users\Application;

use App\Events\Application\FindEventById;
use App\Users\Domain\FindUserById;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Annotations as OA;

/*
 * Acción de un usuario de dar me gusta a un evento. Añade el evento a la lista de eventos que le gustan al usuario.
 * */
final class UserLikeEvent extends UserAction
{
    /**
     * @OA\Put(
     *     path="/users/like",
     *     tags={"Users"},
     *     summary="Agrega un evento a la lista de eventos gustados del usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos necesarios para agregar un evento a la lista de eventos gustados del usuario",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"id", "eventId"},
     *                 @OA\Property(property="id", type="string", format="uuid", description="ID del usuario"),
     *                 @OA\Property(
     *                      property="eventId", type="string",
     *                      format="uuid",
     *                      description="ID del evento a agregar a la lista de eventos gustados del usuario"
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
        $userId = $data['id'];
        $eventId = $data['eventId'];

        $user = $this->userFinder->findUserById($userId);
        $this->eventFinder->findEventById($eventId);
        $user->addLikedEvent($eventId);
        $this->repository->save($user);
        return $this->respondWithData();
    }
}
