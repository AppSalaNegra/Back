<?php

declare(strict_types=1);

namespace App\Users\Application\Actions;

use App\Users\Domain\User;
use App\Users\Domain\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Serializer\SerializerInterface;

final class UserGetLikedShowsAction extends UserAction
{
    private SerializerInterface $serializer;

    public function __construct(UserRepository $repository, SerializerInterface $serializer)
    {
        parent::__construct($repository);
        $this->serializer = $serializer;
    }

    protected function action(): Response
    {
        $data = $this->getFormData();
        $userId = $data['id'];
        $user = $this->repository->findById($userId);
        return $this->respondWithData(['userEvents' => $this->getAllUserEvents($user)]);
    }

    private function getAllUserEvents(User $user): array
    {
        $events = [];
        foreach ($user->getLikedShows() as $eventId) {
            //TODO: find event by id
            $events[] = [

            ];
        }
        return $events;
    }
}