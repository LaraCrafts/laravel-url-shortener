<?php

namespace LaraCrafts\UrlShortener\Concerns;

use Psr\Http\Message\UriInterface;

interface ToPromise
{
    /**
     * Shorten the given URI asynchronously.
     *
     * @param \Psr\Http\Message\UriInterface $uri
     * @param array $options
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function toPromise(UriInterface $uri, array $options);
}
