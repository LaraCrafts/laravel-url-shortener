<?php

namespace LaraCrafts\UrlShortener\Contracts;

interface Factory
{
    /**
     * Get a shortening driver by name, wrapped in a client.
     *
     * @param string|null $name
     * @return \LaraCrafts\UrlShortener\Contracts\Client
     */
    public function client(string $name = null);
}
