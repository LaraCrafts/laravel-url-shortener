<?php

namespace LaraCrafts\UrlShortener\Contracts;

interface Client
{
    /**
     * Get the underlying driver.
     *
     * @return object
     */
    public function driver();

    /**
     * Create a new shortening builder.
     *
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @param array $options
     * @return \LaraCrafts\UrlShortener\Builder
     */
    public function shorten($uri, array $options = []);
}
