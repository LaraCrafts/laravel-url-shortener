<?php

namespace LaraCrafts\UrlShortener\Http;

use LaraCrafts\UrlShortener\Concerns\ToString;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriInterface;

class TinyUrl implements ToString
{
    protected $httpClient;
    protected $requestFactory;

    /**
     * Create a new TinyURL shortening driver.
     *
     * @param \Psr\Http\Client\ClientInterface $client
     * @param \Psr\Http\Message\RequestFactoryInterface $requestFactory
     * @return void
     */
    public function __construct(ClientInterface $client, RequestFactoryInterface $requestFactory)
    {
        $this->httpClient = $client;
        $this->requestFactory = $requestFactory;
    }

    /**
     * {@inheritDoc}
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function toString(UriInterface $uri, array $options): string
    {
        $query = http_build_query(array_merge($options, ['url' => (string)$uri]));
        $request = $this->requestFactory->createRequest('POST', "https://tinyurl.com/api-create.php?$query");
        $response = $this->httpClient->sendRequest($request);

        return str_replace('http://', 'https://', $response->getBody()->getContents());
    }
}
