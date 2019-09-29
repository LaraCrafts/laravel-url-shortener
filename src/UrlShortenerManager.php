<?php

namespace LaraCrafts\UrlShortener;

use Illuminate\Support\Manager;
use LaraCrafts\UrlShortener\Contracts\Factory;
use LaraCrafts\UrlShortener\Http\TinyUrl;
use Psr\Http\Message\UriFactoryInterface;

class UrlShortenerManager extends Manager implements Factory
{
    /**
     * {@inheritDoc}
     */
    public function client(string $name = null)
    {
        return $this->driver($name);
    }

    /**
     * Create an instance of the TinyURL driver.
     *
     * @return \LaraCrafts\UrlShortener\UrlShortener
     */
    protected function createTinyUrlDriver()
    {
        return new UrlShortener($this->app[TinyUrl::class], $this->app[UriFactoryInterface::class]);
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['url-shortener.default'];
    }

    /**
     * Set the default URL shortening driver name.
     *
     * @param string $name
     * @return void
     */
    public function setDefaultDriver(string $name)
    {
        $this->app['config']['session.driver'] = $name;
    }
}
