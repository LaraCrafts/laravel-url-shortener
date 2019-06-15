<?php

namespace LaraCrafts\UrlShortener\Http;

use GuzzleHttp\ClientInterface;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;

class BitLyShortener extends RemoteShortener
{
    protected $client;
    protected $defaults;

    /**
     * Create a new Bit.ly shortener.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $token
     * @param string $domain
     * @return void
     */
    public function __construct(ClientInterface $client, string $token, string $domain)
    {
        $this->client = $client;
        $this->defaults = [
            'allow_redirects' => false,
            'base_uri' => 'https://api-ssl.bitly.com',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "Bearer $token",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'domain' => $domain,
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function shortenAsync($url, array $options = [])
    {
        $options = array_merge_recursive(Arr::add($this->defaults, 'json.long_url', $url), $options);
        $request = new Request('POST', '/v4/shorten');

        return $this->client->sendAsync($request, $options)->then(function (ResponseInterface $response) {
            return str_replace('http://', 'https://', json_decode($response->getBody()->getContents())->link);
        });
    }
}
