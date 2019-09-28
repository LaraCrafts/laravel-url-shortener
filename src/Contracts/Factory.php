<?php

namespace LaraCrafts\UrlShortener\Contracts;

interface Factory
{
    /**
     * Get a client instance.
     *
     * @param string|null $name
     * @return \LaraCrafts\UrlShortener\Contracts\Client
     */
    public function client(string $name = null);
}
