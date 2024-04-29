<?php

namespace App\Shared\Infrastructure;

use DateTime;
use GuzzleHttp\Client;
use http\Env\Response;

class ActuaApiHandler
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getPostsData(): array
    {
        $response = $this->client->request('POST', 'https://sala-negra.com/actua_public_api_v1/get_posts');
        if ($response->getStatusCode() === 200) {
            $data      = $response->getBody()->getContents();
            $dataArray = json_decode($data, true);
            return $dataArray['posts'];
        }
        return [];
    }

    public function getUpcomingEventsData(): array
    {
        $response = $this->client->request('POST', 'https://sala-negra.com/actua_public_api_v1/get_events');
        if ($response->getStatusCode() === 200) {
            $data      = $response->getBody()->getContents();
            $dataArray = json_decode($data, true);
            return $dataArray['events'];
        }
        return [];
    }

    public function getParentEventsTwoMonthsAgo(): array
    {
        $today = new DateTime();
        $period = $today->modify('-2 months');
        $today = new DateTime();
        $apiUrl = 'https://sala-negra.com/actua_public_api_v1/get_events?start=' . $period->format('Y-m-d') . '&finish=' . $today->format('Y-m-d');
        $response = $this->client->request('POST', $apiUrl);
        if ($response->getStatusCode() === 200) {
            $data      = $response->getBody()->getContents();
            $dataArray = json_decode($data, true);
            return $this->selectOnlyParentEvents($dataArray['events']);
        }
        return [];
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
