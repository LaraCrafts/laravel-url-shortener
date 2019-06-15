<?php

namespace LaraCrafts\UrlShortener\Http;

use GuzzleHttp\ClientInterface;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;

class FirebaseShortener extends RemoteShortener
{
    protected $client;
    protected $defaults;

    /**
     * Create a new Firebase shortener.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $token
     * @param string $domain
     * @param string $suffix
     * @return void
     */
    public function __construct(ClientInterface $client, string $token, string $domain, string $suffix)
    {
        $this->client = $client;
        $this->defaults = [
            'allow_redirects' => false,
            'base_uri' => 'https://firebasedynamiclinks.googleapis.com',
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'query' => [
                'key' => $token,
            ],
            'json' => [
                'dynamicLinkInfo' => [
                    'domainUriPrefix' => $domain,
                ],
                'suffix' => [
                    "option" => $suffix,
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function shortenAsync($url, array $options = [])
    {
        $options = array_merge_recursive(Arr::add($this->defaults, 'json.dynamicLinkInfo.link', $url), $options);
        $request = new Request('POST', '/v1/shortLinks');

        return $this->client->sendAsync($request, $options)->then(function (ResponseInterface $response) {
            return json_decode($response->getBody()->getContents())->shortLink;
        });
    }
}
