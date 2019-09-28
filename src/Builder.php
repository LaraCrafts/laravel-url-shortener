<?php

namespace LaraCrafts\UrlShortener;

use LaraCrafts\UrlShortener\Concerns\CustomDomains;
use LaraCrafts\UrlShortener\Concerns\CustomSuffixes;
use LaraCrafts\UrlShortener\Concerns\ToPromise;
use LaraCrafts\UrlShortener\Concerns\ToString;
use LaraCrafts\UrlShortener\Concerns\ToUri;
use LaraCrafts\UrlShortener\Contracts\Client;
use LaraCrafts\UrlShortener\Contracts\UnsupportedOperationException;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

class Builder
{
    protected $client;
    protected $factory;
    protected $options;
    protected $uri;

    /**
     * Create a new shortening builder instance.
     *
     * @param \LaraCrafts\UrlShortener\Contracts\Client $client
     * @param \Psr\Http\Message\UriFactoryInterface $factory
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @param array $options
     * @return void
     */
    public function __construct(Client $client, UriFactoryInterface $factory, $uri, array $options)
    {
        $this->client = $client;
        $this->factory = $factory;
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
     * Set the domain to shorten to.
     *
     * @param string $domain
     * @return $this
     */
    public function domain(string $domain)
    {
        $driver = $this->getClient()->driver();

        if (!$driver instanceof CustomDomains) {
            throw new UnsupportedOperationException('Applying a custom domain is not supported');
        }

        $driver->withDomain($this, $domain);

        return $this;
    }

    /**
     * Get the shortened URI.
     *
     * @return \Psr\Http\Message\UriInterface
     */
    public function get()
    {
        $driver = $this->getClient()->driver();

        if ($driver instanceof ToUri) {
            $uri = $driver->toUri($this->uri, $this->options);
        } elseif ($driver instanceof ToString) {
            $uri = $driver->toString($this->uri, $this->options);
        } elseif ($driver instanceof ToPromise) {
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
     * @param mixed $uri
     * @return \Psr\Http\Message\UriInterface
     */
    protected function parseUri($uri)
    {
        if ($uri instanceof UriInterface) {
            return $uri;
        }

        return $this->factory->createUri($uri);
    }

    /**
     * Set the suffix to shorten to.
     *
     * @param string $suffix
     * @return $this
     */
    public function to(string $suffix)
    {
        $driver = $this->getClient()->driver();

        if (!$driver instanceof CustomSuffixes) {
            throw new UnsupportedOperationException('Applying a custom suffix is not supported');
        }

        $driver->withSuffix($this, $suffix);

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

    /**
     * Get the shortened URI as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->get();
    }
}
