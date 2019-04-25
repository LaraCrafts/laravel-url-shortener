<?php

namespace LaraCrafts\UrlShortener\Http;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\json_decode;

class FirebaseShortener extends RemoteShortener
{
    private static $SUFFIXES = ['UNGUESSABLE', 'SHORT'];

    protected $client;
    protected $defaults;

    /**
     * Create a new Shorte.st shortener.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $token
     * @param string $domain
     * @param string $suffix
     */
    public function __construct(ClientInterface $client, string $token, string $domain, string $suffix)
    {
        if (!Arr::has(self::$SUFFIXES, Str::upper($suffix))) {
            $suffix = self::$SUFFIXES[0];
        }

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
     * Shorten the given URL asynchronously.
     *
     * @param \Psr\Http\Message\UriInterface|string $url
     * @param array $options
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function shortenAsync($url, array $options = [])
    {
        $options = array_merge(Arr::add($this->defaults, 'json.dynamicLinkInfo.link', $url), $options);
        $request = new Request('POST', '/v1/shortLinks');

        return $this->client->sendAsync($request, $options)->then(function (ResponseInterface $response) {
            return json_decode($response->getBody()->getContents())->shortLink;
        });
    }
}
