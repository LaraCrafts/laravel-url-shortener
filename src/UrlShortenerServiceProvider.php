<?php

namespace LaraCrafts\UrlShortener;

use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
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
        $this->resolveFactories();
        $this->resolveHttpClient();
    }

    /**
     * Register a PSR-18 compatible HTTP client.
     *
     * @return void
     */
    protected function resolveHttpClient()
    {
        if ($this->app->bound(ClientInterface::class)) {
            return;
        }

        if (class_exists('\Http\Adapter\Guzzle6\Client')) {
            # PHP-HTTP adapter for Guzzle 6
            $this->app->bind(ClientInterface::class, '\Http\Adapter\Guzzle6\Client');
        }
    }

    /**
     * Register a PSR-17 compatible Request and URI factory.
     *
     * @return void
     */
    protected function resolveFactories()
    {
        if ($this->app->bound(UriFactoryInterface::class)) {
            return;
        }

        if (class_exists('\GuzzleHttp\Psr7\HttpFactory')) {
            # Guzzle 7
            $this->app->bind(RequestFactoryInterface::class, '\GuzzleHttp\Psr7\HttpFactory');
            $this->app->bind(UriFactoryInterface::class, '\GuzzleHttp\Psr7\HttpFactory');
        } elseif (class_exists('\Http\Factory\Guzzle\UriFactory')) {
            # HTTP Interop adapter for Guzzle 6
            $this->app->bind(RequestFactoryInterface::class, '\Http\Factory\Guzzle\RequestFactory');
            $this->app->bind(UriFactoryInterface::class, '\Http\Factory\Guzzle\UriFactory');
        }
    }
}
