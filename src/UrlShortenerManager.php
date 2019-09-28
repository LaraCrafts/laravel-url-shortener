<?php

namespace LaraCrafts\UrlShortener;

use Illuminate\Support\Manager;
use LaraCrafts\UrlShortener\Contracts\Factory;

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
