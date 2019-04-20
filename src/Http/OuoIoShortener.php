<?php

namespace LaraCrafts\UrlShortener\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;

class OuoIoShortener extends RemoteShortener
{
    protected $client;
    protected $defaults;
    protected $token;

    /**
     * Create a new Ouo.io shortener.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $token
     * @return void
     */
    public function __construct(ClientInterface $client, string $token)
    {
        $this->client = $client;
        $this->defaults = [
            'allow_redirects' => false,
            'base_uri' => 'https://ouo.io',
        ];
        $this->token = $token;
    }

    /**
     * {@inheritDoc}
     */
    public function shortenAsync($url, array $options = [])
    {
        $options = array_merge(Arr::add($this->defaults, 'query.s', $url), $options);
        $request = new Request('GET', "/api/$this->token");

        return $this->client->sendAsync($request, $options)->then(function (ResponseInterface $response) {
            return $response->getBody()->getContents();
        });
    }
}
