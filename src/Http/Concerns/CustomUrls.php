<?php

namespace LaraCrafts\UrlShortener\Http\Concerns;

trait CustomUrls
{
    /**
     * Shorten the given URL to the given identifier.
     *
     * @param \Psr\Http\Message\UriInterface|string $url
     * @param string $identifier
     * @param array $options
     * @return string
     */
    public function shortenTo($url, string $identifier, array $options = [])
    {
        return $this->shortenToAsync($url, $identifier, $options)->wait();
    }

    /**
     * Shorten the given URL to the given identifier asynchronously.
     *
     * @param \Psr\Http\Message\UriInterface|string $url
     * @param string $identifier
     * @param array $options
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    abstract public function shortenToAsync($url, string $identifier, array $options = []);
}
