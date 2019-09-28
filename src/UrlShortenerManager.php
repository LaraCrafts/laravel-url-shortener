<?php

namespace LaraCrafts\UrlShortener;

use Illuminate\Support\Manager;

class UrlShortenerManager extends Manager
{
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
