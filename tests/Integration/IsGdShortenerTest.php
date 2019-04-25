<?php

namespace LaraCrafts\UrlShortener\Tests\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use LaraCrafts\UrlShortener\Http\IsGdShortener;
use LaraCrafts\UrlShortener\Tests\Concerns\FollowsRedirects;
use LaraCrafts\UrlShortener\Tests\Constraint\IsValidUrl;
use Orchestra\Testbench\TestCase;

class IsGdShortenerTest extends TestCase
{
    use FollowsRedirects;

    /**
     * @var \LaraCrafts\UrlShortener\Http\IsGdShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->shortener = new IsGdShortener(new Client, false, false);
    }

    /**
     * Test Is.gd synchronous shortening.
     *
     * @return void
     */
    public function testShorten()
    {
        $shortUrl = $this->shortener->shorten('https://google.com');
        $this->assertInternalType('string', $shortUrl);
        $this->assertThat($shortUrl, new IsValidUrl());
        $this->assertRedirectsTo('https://google.com', $shortUrl, 1);
    }

    /**
     * Test Is.gd asynchronous shortening.
     *
     * @return void
     */
    public function testShortenAsync()
    {
        $promise = $this->shortener->shortenAsync('https://google.com');
        $this->assertInstanceOf(PromiseInterface::class, $promise);
        $shortUrl = $promise->wait();
        $this->assertInternalType('string', $shortUrl);
        $this->assertThat($shortUrl, new IsValidUrl());
        $this->assertRedirectsTo('https://google.com', $shortUrl, 1);
    }
}
