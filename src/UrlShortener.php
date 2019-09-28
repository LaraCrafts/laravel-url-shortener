<?php

namespace LaraCrafts\UrlShortener;

use LaraCrafts\UrlShortener\Contracts\Client;

class UrlShortener implements Client
{
    protected $driver;

    /**
     * Create a new URL shortener.
     *
     * @param object $driver
     * @return void
     */
    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    /**
     * {@inheritDoc}
     */
    public function driver()
    {
        return $this->driver;
    }

    /**
     * {@inheritDoc}
     */
    public function shorten($uri)
    {
        return new Builder($this, $uri);
    }
}
