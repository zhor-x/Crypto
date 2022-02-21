<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

/**
 *
 */
class NewsApiService
{

    /**
     *
     */
    private const URI = 'everything';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    /**
     * @param string $query
     * @param int $page
     *
     * @return \Illuminate\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $query, int $page = 1):Collection
    {
        config(['app.news.query.q' => $query]);
        config(['app.news.query.page' => $page]);
        $res = $this->client->get(self::URI, ['query' => config('app.news.query')]);
        $json = json_decode($res->getBody());
        return collect($json->articles)->first();
    }
}
