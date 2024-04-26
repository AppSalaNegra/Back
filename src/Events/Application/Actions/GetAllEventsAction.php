<?php

namespace App\Events\Application\Actions;

use App\Events\Domain\Event;
use DateTime;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;

final class GetAllEventsAction extends EventAction
{
    protected function action(): Response
    {
        $this->updateDbFromPublicApi();
        $events = $this->repository->getAll();
        return $this->respondWithData(['events' => $events]);
    }

    private function updateDbFromPublicApi(): void
    {
        $client   = new Client();
        $response = $client->request('POST', 'https://sala-negra.com/actua_public_api_v1/get_events');
        if ($response->getStatusCode() === 200) {
            $data      = $response->getBody()->getContents();
            $dataArray = json_decode($data, true);
            $this->persistIfNotExists($dataArray['events']);
        }
    }

    private function persistIfNotExists(array $eventsArray): void
    {
        foreach ($eventsArray as $eventData) {
            $startDateTime  = DateTime::createFromFormat("Y-m-d\TH:i:s", $eventData['startDateTime']);
            $finishDateTime = DateTime::createFromFormat("Y-m-d\TH:i:s", $eventData['finishDateTime']);
            $title          = $eventData['title'];
            $excerpt        = $eventData['excerpt'];
            $url            = $eventData['url'];
            $thumbnail_url  = $eventData['thumbnail_url'];
            $cats           = $eventData['cats'];
            $post           = new Event($startDateTime, $finishDateTime, $title, $excerpt, $url, $thumbnail_url, $cats);
            if (null === $this->repository->findByTitle($post->getTitle())) {
                $this->repository->save($post);
            }
        }
    }
}
