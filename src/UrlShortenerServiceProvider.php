<?php

namespace LaraCrafts\UrlShortener;

use Http\Discovery\Psr17FactoryDiscovery;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
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
     * Register PSR-17 compatible factories to the container.
     *
     * @return void
     */
    protected function resolveFactories()
    {
        $this->app->bindIf(RequestFactoryInterface::class, function () {
            return Psr17FactoryDiscovery::findRequestFactory();
        });

        $this->app->bindIf(ResponseFactoryInterface::class, function () {
            return Psr17FactoryDiscovery::findResponseFactory();
        });

        $this->app->bindIf(UriFactoryInterface::class, function () {
            return Psr17FactoryDiscovery::findUrlFactory();
        });
    }
}
