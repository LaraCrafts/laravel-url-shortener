<?php

namespace LaraCrafts\UrlShortener\Contracts;

interface Shortener
{
    /**
     * Shorten the given URL.
     *
     * @param \Psr\Http\Message\UriInterface|string $url
     * @param array $options
     * @return string
     */
    public function shorten($url, array $options = []);

    /**
     * Shorten the given URL asynchronously.
     *
     * @param \Psr\Http\Message\UriInterface|string $url
     * @param array $options
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function shortenAsync($url, array $options = []);
}
