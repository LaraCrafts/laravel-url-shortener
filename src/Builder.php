<?php

namespace LaraCrafts\UrlShortener;

use GuzzleHttp\Psr7\Uri;
use InvalidArgumentException;
use LaraCrafts\UrlShortener\Concerns\ToPromise;
use LaraCrafts\UrlShortener\Concerns\WithSuffixes;
use LaraCrafts\UrlShortener\Contracts\Client;
use LaraCrafts\UrlShortener\Contracts\UnsupportedOperationException;
use Psr\Http\Message\UriInterface;

class Builder
{
    protected $client;
    protected $options;
    protected $uri;

    /**
     * Create a new shortening builder instance.
     *
     * @param \LaraCrafts\UrlShortener\Contracts\Client $client
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @param array $options
     * @return void
     */
    public function __construct(Client $client, $uri, array $options)
    {
        $this->client = $client;
        $this->options = $options;
        $this->uri = $this->parseUri($uri);
    }

    /**
     * Get the shortened URI asynchronously.
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function async()
    {
        $driver = $this->getClient()->driver();
        $promise = null;

        if ($driver instanceof ToPromise) {
            $promise = $driver->toPromise($this->uri, $this->options);
        } else {
            throw new UnsupportedOperationException('Async URL shortening is not supported');
        }

        return $promise->then(function ($uri) {
            return $this->parseUri($uri);
        });
    }

    /**
     * Get the shortened URI.
     *
     * @return \Psr\Http\Message\UriInterface
     */
    public function get()
    {
        $driver = $this->getClient()->driver();
        $uri = null;

        if ($driver instanceof ToPromise) {
            $uri = $driver->toPromise($this->uri, $this->options)->wait();
        } else {
            throw new UnsupportedOperationException('URL shortening is not supported');
        }

        return $this->parseUri($uri);
    }

    /**
     * Get the client.
     *
     * @return \LaraCrafts\UrlShortener\Contracts\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Get the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get the URI.
     *
     * @return \Psr\Http\Message\UriInterface
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Parse the given URI.
     *
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @return \Psr\Http\Message\UriInterface
     */
    protected function parseUri($uri)
    {
        if ($uri instanceof UriInterface) {
            return $uri;
        }

        if (is_string($uri) || (is_object($uri) && method_exists($uri, '__toString'))) {
            return new Uri((string)$uri);
        }

        throw new InvalidArgumentException('URI must be a string or UriInterface');
    }

    /**
     * Set the suffix to shorten to.
     *
     * @param string $suffix
     * @return $this
     */
    public function toSuffix(string $suffix)
    {
        $driver = $this->getClient()->driver();

        if (!$driver instanceof WithSuffixes) {
            throw new UnsupportedOperationException('Applying a custom suffix is not supported');
        }

        $driver->applySuffix($this, $suffix);

        return $this;
    }

    /**
     * Add a piece of data to the builder.
     *
     * @param array|string $key
     * @param mixed|null $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->options = array_merge($this->options, $key);
        } else {
            $this->options[$key] = $value;
        }

        return $this;
    }
}
