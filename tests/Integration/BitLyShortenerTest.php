<?php

namespace LaraCrafts\UrlShortener\Tests\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use LaraCrafts\UrlShortener\Http\BitLyShortener;
use LaraCrafts\UrlShortener\Tests\Concerns\FollowsRedirects;
use LaraCrafts\UrlShortener\Tests\Constraint\IsValidUrl;
use Orchestra\Testbench\TestCase;

class BitLyShortenerTest extends TestCase
{
    use FollowsRedirects;

    /**
     * @var \LaraCrafts\UrlShortener\Http\BitLyShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        if (!$token = env('BIT_LY_API_TOKEN')) {
            $this->markTestSkipped('No Bit.ly API token set');
        }

        $this->shortener = new BitLyShortener(new Client, $token, 'bit.ly');
    }

    /**
     * Test Bit.ly synchronous shortening.
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
     * Test Bit.ly asynchronous shortening.
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
