<?php

namespace LaraCrafts\UrlShortener\Contracts;

interface Factory
{
    /**
     * Get a shortener instance.
     *
     * @param string|null $driver
     * @return \LaraCrafts\UrlShortener\Contracts\Shortener
     */
    public function driver($driver = null);
}
