<?php

namespace App\Shared\Infrastructure;

use GuzzleHttp\Client;

class ActuaApiHandler
{
    public function getPostsData(): array
    {
        $client = new Client();
        $response = $client->request('POST', 'https://sala-negra.com/actua_public_api_v1/get_posts');
        if ($response->getStatusCode() === 200) {
            $data = $response->getBody()->getContents();
            $dataArray = json_decode($data, true);
            return $dataArray['posts'];
        }
        return [];
    }
    public function getEventsData(): array
    {
        $client   = new Client();
        $response = $client->request('POST', 'https://sala-negra.com/actua_public_api_v1/get_events');
        if ($response->getStatusCode() === 200) {
            $data      = $response->getBody()->getContents();
            $dataArray = json_decode($data, true);
            return $dataArray['events'];
        }
        return [];
    }
}
