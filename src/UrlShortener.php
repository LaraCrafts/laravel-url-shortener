<?php

namespace LaraCrafts\UrlShortener;

use LaraCrafts\UrlShortener\Contracts\Client;
use Psr\Http\Message\UriFactoryInterface;

class UrlShortener implements Client
{
    protected $driver;
    protected $factory;
    protected $options;

    /**
     * Create a new URL shortener.
     *
     * @param object $driver
     * @param \Psr\Http\Message\UriFactoryInterface $factory
     * @param array $options
     * @return void
     */
    public function __construct($driver, UriFactoryInterface $factory, array $options = [])
    {
        $this->driver = $driver;
        $this->factory = $factory;
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
        return new Builder($this, $this->factory, $uri, array_merge_recursive($this->options, $options));
    }
}
