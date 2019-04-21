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
     * @param bool $linkPreviews
     * @param bool $statistics
     * @return void
     */
    public function __construct(ClientInterface $client, bool $linkPreviews, bool $statistics)
    {
        $this->client = $client;
        $this->defaults = [
            'allow_redirects' => false,
            'base_uri' => $linkPreviews ? 'https://v.gd' : 'https://is.gd',
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
        $options = Arr::add(array_merge($this->defaults, $options), 'query.url', $url);
        $request = new Request('GET', '/create.php');

        return $this->client->sendAsync($request, $options)->then(function (ResponseInterface $response) {
            return $response->getBody()->getContents();
        });
    }
}
