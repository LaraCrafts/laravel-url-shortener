<?php

namespace LaraCrafts\UrlShortener;

use Illuminate\Support\ServiceProvider;
use Psr\Http\Message\UriFactoryInterface;

class UrlShortenerServiceProvider extends ServiceProvider
{
    /**
     * Register URL shortening services.
     *
     * @return void
     */
    public function register()
    {
        $this->resolveUriFactory();
    }

    /**
     * Register a PSR-17 compatible URI factory.
     *
     * @return void
     */
    protected function resolveUriFactory()
    {
        if ($this->app->bound(UriFactoryInterface::class)) {
            return;
        }

        if (class_exists('\GuzzleHttp\Psr7\HttpFactory')) {
            # Guzzle 7
            $this->app->bind(UriFactoryInterface::class, '\GuzzleHttp\Psr7\HttpFactory');
        } elseif (class_exists('\Http\Factory\Guzzle\UriFactory')) {
            # HTTP Interop adapter for Guzzle 6
            $this->app->bind(UriFactoryInterface::class, '\Http\Factory\Guzzle\UriFactory');
        } elseif (class_exists('\Zend\Diactoros\UriFactory')) {
            # Zend Diactoros
            $this->app->bind(UriFactoryInterface::class, '\Zend\Diactoros\UriFactory');
        }
    }
}
