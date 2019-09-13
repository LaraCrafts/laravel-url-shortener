<?php

namespace LaraCrafts\UrlShortener\Concerns;

use Psr\Http\Message\UriInterface;

interface ToUri
{
    /**
     * Shorten the given URI.
     *
     * @param \Psr\Http\Message\UriInterface $uri
     * @param array $options
     * @return \Psr\Http\Message\UriInterface
     */
    public function toUri(UriInterface $uri, array $options): UriInterface;
}
