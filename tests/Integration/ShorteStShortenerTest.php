<?php

namespace LaraCrafts\UrlShortener\Tests\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use LaraCrafts\UrlShortener\Http\ShorteStShortener;
use LaraCrafts\UrlShortener\Tests\Constraint\IsValidUrl;
use Orchestra\Testbench\TestCase;

class ShorteStShortenerTest extends TestCase
{
    /**
     * @var \LaraCrafts\UrlShortener\Http\ShorteStShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        if (!$token = env('SHORTE_ST_API_TOKEN')) {
            $this->markTestSkipped('No Shorte.st API token set');
        }

        $this->shortener = new ShorteStShortener(new Client, $token);
    }

    /**
     * Test Shorte.st synchronous shortening.
     *
     * @return void
     */
    public function testShorten()
    {
        $shortUrl = $this->shortener->shorten('https://google.com');
        $this->assertInternalType('string', $shortUrl);
        $this->assertThat($shortUrl, new IsValidUrl());
    }

    /**
     * Test Shorte.st asynchronous shortening.
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
    }
}
