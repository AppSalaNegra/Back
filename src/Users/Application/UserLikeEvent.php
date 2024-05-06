<?php

namespace App\Users\Application;

use App\Events\Application\FindEventById;
use App\Users\Domain\FindUserById;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;

/*
 * Acción de un usuario de dar me gusta a un evento. Añade el evento a la lista de eventos que le gustan al usuario.
 * */
final class UserLikeEvent extends UserAction
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
        $user->addLikedEvent($eventId);
        $this->repository->save($user);
        return $this->respondWithData();
    }
}
