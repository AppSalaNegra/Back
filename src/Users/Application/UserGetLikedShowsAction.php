<?php

declare(strict_types=1);

namespace App\Users\Application;

use App\Events\Application\FindEventById;
use App\Users\Domain\Exception\UserNotFound;
use App\Users\Domain\User;
use App\Users\Domain\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;

final class UserGetLikedShowsAction extends UserAction
{
    public function __construct(UserRepository $repository, private readonly FindEventById $eventFinder)
    {
        parent::__construct($repository);
    }

    protected function action(): Response
    {
        $data = $this->getFormData();
        $userId = $data['id'];
        $user = $this->repository->findById($userId);
        if (null === $user) {
            throw new UserNotFound();
        }
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
