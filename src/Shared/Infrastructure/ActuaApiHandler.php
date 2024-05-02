<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\AppConstants;
use DateTime;
use GuzzleHttp\Client;

class ActuaApiHandler
{
    public function __construct(private readonly Client $client)
    {
    }

    public function getPostsData(): array
    {
        $response = $this->client->request('POST', AppConstants::$ACTUA_GET_POSTS);
        if ($response->getStatusCode() === 200) {
            $data = $response->getBody()->getContents();
            $dataArray = json_decode($data, true);
            return $dataArray['posts'];
        }
        throw new ActuaApiFailed();
    }

    public function getUpcomingEventsData(): array
    {
        $response = $this->client->request('POST', AppConstants::$ACTUA_GET_EVENTS);
        if ($response->getStatusCode() === 200) {
            $data = $response->getBody()->getContents();
            $dataArray = json_decode($data, true);
            return $dataArray['events'];
        }
        throw new ActuaApiFailed();
    }

    public function getParentEvents(): array
    {
        $today = new DateTime();
        $start = $today->modify('-2 months')->format('Y-m-d');
        $today = new DateTime();
        $finish = $today->modify('+1 month')->format('Y-m-d');
        $apiUrl = AppConstants::$ACTUA_FILTER_EVENTS . $start . '&finish=' . $finish;
        $response = $this->client->request('POST', $apiUrl);
        if ($response->getStatusCode() === 200) {
            $data = $response->getBody()->getContents();
            $dataArray = json_decode($data, true);
            return $this->selectOnlyParentEvents($dataArray['events']);
        }
        throw new ActuaApiFailed();
    }

    private function selectOnlyParentEvents(array $eventsData): array
    {
        $parentArray = [];
        foreach ($eventsData as $event) {
            if ($event['hierarchy'] === 'parent') {
                $parentArray [] = $event;
            }
        }
        return $parentArray;
    }
}
