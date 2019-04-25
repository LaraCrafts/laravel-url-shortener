<?php

namespace LaraCrafts\UrlShortener\Tests\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use LaraCrafts\UrlShortener\Http\TinyUrlShortener;
use LaraCrafts\UrlShortener\Tests\Concerns\FollowsRedirects;
use LaraCrafts\UrlShortener\Tests\Constraint\IsValidUrl;
use Orchestra\Testbench\TestCase;

class TinyUrlShortenerTest extends TestCase
{
    use FollowsRedirects;

    /**
     * @var \LaraCrafts\UrlShortener\Http\TinyUrlShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->shortener = new TinyUrlShortener(new Client);
    }

    /**
     * Test TinyURL synchronous shortening.
     *
     * @return void
     */
    public function testShorten()
    {
        $shortUrl = $this->shortener->shorten('https://google.com');
        $this->assertThat($shortUrl, new IsValidUrl());
        $this->assertRedirectsTo('https://google.com', $shortUrl, 1);
    }

    /**
     * Test TinyURL asynchronous shortening.
     *
     * @return void
     */
    public function testShortenAsync()
    {
        $promise = $this->shortener->shortenAsync('https://google.com');
        $this->assertInstanceOf(PromiseInterface::class, $promise);
        $shortUrl = $promise->wait();
        $this->assertThat($shortUrl, new IsValidUrl());
        $this->assertRedirectsTo('https://google.com', $shortUrl, 1);
    }
}
