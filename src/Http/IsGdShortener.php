<?php

namespace LaraCrafts\UrlShortener\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;

class IsGdShortener extends RemoteShortener
{
    protected $client;
    protected $defaults;

    /**
     * Create a new Is.gd shortener.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param \Psr\Http\Message\UriInterface|string $baseUri
     * @param bool $statistics
     * @return void
     */
    public function __construct(ClientInterface $client, $baseUri, bool $statistics)
    {
        $this->client = $client;
        $this->defaults = [
            'allow_redirects' => false,
            'base_uri' => (string)$baseUri,
            'query' => [
                'format' => 'simple',
                'logstats' => intval($statistics),
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function shortenAsync($url, array $options = [])
    {
        $options = Arr::add(array_merge_recursive($this->defaults, $options), 'query.url', $url);
        $request = new Request('GET', '/create.php');

        return $this->client->sendAsync($request, $options)->then(function (ResponseInterface $response) {
            return $response->getBody()->getContents();
        });
    }
}
