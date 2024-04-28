<?php

namespace App\Users\Application;

use App\Events\Application\FindEventById;
use App\Events\Domain\EventNotFound;
use App\Users\Domain\Exception\UserNotFound;
use App\Users\Domain\User;
use App\Users\Domain\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;

final class UserDislikeEvent extends UserAction
{
    public function __construct(UserRepository $repository, private readonly FindEventById $eventFinder)
    {
        parent::__construct($repository);
    }

    protected function action(): Response
    {
        $data = $this->getFormData();
        $userId = $data['userId'];
        $eventId = $data['eventId'];

        $this->ensureEventExists($eventId);
        $user = $this->ensureUserExists($userId);
        $user->removeLikedEvent($eventId);
        $this->repository->save($user);
        return $this->respondWithData();
    }

    private function ensureEventExists(string $eventId): void
    {
        $event = $this->eventFinder->findEventById($eventId);
        if (null === $event) {
            throw new EventNotFound();
        }
    }

    private function ensureUserExists(string $userId): User
    {
        $user = $this->repository->findById($userId);
        if (null === $user) {
            throw new UserNotFound();
        }
        return $user;
    }
}
