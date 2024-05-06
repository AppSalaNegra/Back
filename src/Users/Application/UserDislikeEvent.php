<?php

namespace App\Users\Application;

use App\Events\Application\FindEventById;
use App\Users\Domain\FindUserById;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;

/*
 * Endpoint para cuando un usuario pulsa el botón de dislike en un evento.
 * Se elimina dicho evento de la lista de eventos del usuario.
 * */
final class UserDislikeEvent extends UserAction
{
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
        $user->removeLikedEvent($eventId);
        $this->repository->save($user);
        return $this->respondWithData();
    }
}
