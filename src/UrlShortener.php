<?php

namespace LaraCrafts\UrlShortener;

use LaraCrafts\UrlShortener\Contracts\Client;

class UrlShortener implements Client
{
    protected $driver;
    protected $options;

    /**
     * Create a new URL shortener.
     *
     * @param object $driver
     * @param array $options
     * @return void
     */
    public function __construct($driver, array $options = [])
    {
        $this->driver = $driver;
        $this->options = $options;
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
    public function shorten($uri, array $options = [])
    {
        return new Builder($this, $uri, array_merge_recursive($this->options, $options));
    }
}
