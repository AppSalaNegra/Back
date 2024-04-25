<?php

declare(strict_types=1);

namespace App\Users\Application\Actions;

use App\Events\Domain\EventsRepository;
use App\Users\Domain\Exception\UserNotFound;
use App\Users\Domain\User;
use App\Users\Domain\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Symfony\Component\Serializer\SerializerInterface;

final class UserGetLikedShowsAction extends UserAction
{
    private SerializerInterface $serializer;
    private EventsRepository $eventsRepository;

    public function __construct(
        UserRepository $repository,
        EventsRepository $eventsRepository,
        SerializerInterface $serializer
    ) {
        parent::__construct($repository);
        $this->serializer = $serializer;
        $this->eventsRepository = $eventsRepository;
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
        $events = [];
        foreach ($user->getLikedShows() as $eventId) {
            $event = $this->eventsRepository->findById($eventId);
            $events[] = $this->serializer->serialize($event, 'json');
        }
        return $events;
    }
}
