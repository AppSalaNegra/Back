<?php

declare(strict_types=1);

namespace App\Users\Application;

use App\Events\Application\FindEventById;
use App\Users\Domain\Exception\UserNotFound;
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
        $userId = $data['id'];
        $user = $this->userFinder->findUserById($userId);
        return $this->respondWithData(['userEvents' => $this->getAllUserEvents($user)]);
    }

    private function getAllUserEvents(User $user): array
    {
        if (empty($user->getLikedShows())) {
            return [];
        }
        return array_map(function ($eventId) {
            $event = $this->eventFinder->findEventById($eventId);
            return $event->jsonSerialize();
        }, $user->getLikedShows());
    }
}
