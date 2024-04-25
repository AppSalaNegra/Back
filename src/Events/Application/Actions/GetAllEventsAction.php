<?php

namespace App\Events\Application\Actions;

use App\Events\Domain\Event;
use App\Events\Domain\EventsRepository;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class GetAllEventsAction extends EventAction
{
    private SerializerInterface $serializer;

    public function __construct(LoggerInterface $logger, EventsRepository $repository, SerializerInterface $serializer)
    {
        parent::__construct($logger, $repository);
        $this->serializer = $serializer;
    }

    protected function action(): Response
    {
        $this->updateDbFromPublicApi();
        $events = $this->repository->getAll();
        return $this->respondWithData(['events' => $events]);
    }

    private function updateDbFromPublicApi(): void
    {
        $client = new Client();
        $response = $client->request('POST', 'https://sala-negra.com/actua_public_api_v1/get_events');
        if ($response->getStatusCode() === 200) {
            $data = $response->getBody()->getContents();
            $eventsData = json_decode($data, true);
            foreach ($eventsData as $eventData) {
                $event = $this->serializer->deserialize(json_encode($eventData), Event::class, 'json');
                $this->repository->save($event);
            }
        }
    }
}
