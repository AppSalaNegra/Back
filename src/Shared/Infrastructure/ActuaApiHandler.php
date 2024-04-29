<?php

namespace App\Shared\Infrastructure;

use GuzzleHttp\Client;

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

    public function getEventsData(): array
    {
        $response = $this->client->request('POST', 'https://sala-negra.com/actua_public_api_v1/get_events');
        if ($response->getStatusCode() === 200) {
            $data      = $response->getBody()->getContents();
            $dataArray = json_decode($data, true);
            return $dataArray['events'];
        }
        return [];
    }

    public function getParentEvents(): array
    {
        $client = new Client();
    }
}
