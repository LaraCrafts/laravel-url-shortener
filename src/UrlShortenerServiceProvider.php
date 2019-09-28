<?php

namespace LaraCrafts\UrlShortener;

use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\UriFactoryInterface;

class UrlShortenerServiceProvider extends ServiceProvider
{
    public $defer = true;

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        return [
            UriFactoryInterface::class,
        ];
    }

    /**
     * Register URL shortening services.
     *
     * @return void
     */
    public function register()
    {
        $this->resolveHttpClient();
        $this->resolveUriFactory();
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
        } elseif (class_exists('\Symfony\Component\HttpClient\Psr18Client')) {
            # Symfony HttpClient component
            $this->app->bind(ClientInterface::class, '\Symfony\Component\HttpClient\Psr18Client');
        } elseif (class_exists('\Http\Client\Curl\Client')) {
            # PHP-HTTP cURL client
            $this->app->bind(ClientInterface::class, '\Http\Client\Curl\Client');
        } elseif (class_exists('\Buzz\Client\Curl')) {
            # Buzz
            $this->app->bind(ClientInterface::class, '\Buzz\Client\Curl');
        }
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
            $this->app->bind(UriFactoryInterface::class, '\GuzzleHttp\Psr7\HttpFactory');
        } elseif (class_exists('\Http\Factory\Guzzle\UriFactory')) {
            $this->app->bind(UriFactoryInterface::class, '\Http\Factory\Guzzle\UriFactory');
        } elseif (class_exists('\Zend\Diactoros\UriFactory')) {
            $this->app->bind(UriFactoryInterface::class, '\Zend\Diactoros\UriFactory');
        }
    }
}
