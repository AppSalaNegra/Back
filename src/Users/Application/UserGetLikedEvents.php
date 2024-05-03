<?php

declare(strict_types=1);

namespace App\Users\Application;

use App\Events\Application\FindEventById;
use App\Users\Domain\FindUserById;
use App\Users\Domain\User;
use App\Users\Domain\UsersRepository;
use Psr\Http\Message\ResponseInterface as Response;

final class UserGetLikedEvents extends UserAction
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
}
