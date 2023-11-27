<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;

class GitHubService
{

    public function __construct(Protected Client $client,Protected ConfigRepository $config)
    {
    }

    public function getPopularRepositories(Request $request)
    {
//        dd($this->config->get('services.github.token'));
        $response = $this->client->get('https://api.github.com/search/repositories', [
            'query' => [
                'q' => 'stars:>1000 language:'.$request['language']??'*',
                'sort' => 'stars',
                'order' => $request['order']??'desc',
                'per_page' => $request['per_page']??10,
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->config->get('services.github.token'),
                'Accept' => 'application/vnd.github.v3+json',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true)['items'];
    }
}
