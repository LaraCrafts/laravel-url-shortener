<?php

namespace LaraCrafts\UrlShortener\Concerns;

use Psr\Http\Message\UriInterface;

interface ToString
{
    /**
     * Shorten the given URI.
     *
     * @param \Psr\Http\Message\UriInterface $uri
     * @param array $options
     * @return string
     */
    public function toString(UriInterface $uri, array $options): string;
}
