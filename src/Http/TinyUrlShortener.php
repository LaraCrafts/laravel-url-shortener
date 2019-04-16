<?php

namespace LaraCrafts\UrlShortener\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;

class TinyUrlShortener extends RemoteShortener
{
    protected $client;
    protected const defaults = [
        'allow_redirects' => false,
        'base_uri' => 'https://tinyurl.com',
    ];

    /**
     * Create a new TinyURL shortener.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @return void
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritDoc}
     */
    public function shortenAsync($url, array $options = [])
    {
        $options = array_merge(Arr::add(static::defaults, 'query.url', $url), $options);
        $request = new Request('GET', '/api-create.php');

        return $this->client->sendAsync($request, $options)->then(function (ResponseInterface $response) {
            return str_replace('http://', 'https://', $response->getBody()->getContents());
        });
    }
}
