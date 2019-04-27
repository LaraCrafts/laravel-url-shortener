<?php

namespace LaraCrafts\UrlShortener\Tests\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Str;
use LaraCrafts\UrlShortener\Http\OuoIoShortener;
use LaraCrafts\UrlShortener\Tests\Concerns\CustomAssertions;
use Orchestra\Testbench\TestCase;

class OuoIoShortenerTest extends TestCase
{
    use CustomAssertions;

    /**
     * @var \LaraCrafts\UrlShortener\Http\OuoIoShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        if (!$token = env('OUO_IO_API_TOKEN')) {
            $this->markTestSkipped('No Ouo.io API token set');
        }

        $this->shortener = new OuoIoShortener(new Client, $token);
    }

    /**
     * Test Ouo.io synchronous shortening.
     *
     * @return void
     */
    public function testShorten()
    {
        $shortUrl = $this->shortener->shorten('https://google.com');

        $this->assertValidUrl($shortUrl);
        $this->assertTrue(Str::startsWith($shortUrl, 'https://ouo.io/'));
    }

    /**
     * Test Ouo.io asynchronous shortening.
     *
     * @return void
     */
    public function testShortenAsync()
    {
        $promise = $this->shortener->shortenAsync('https://google.com');

        $this->assertInstanceOf(PromiseInterface::class, $promise);
        $this->assertValidUrl($shortUrl = $promise->wait());
        $this->assertTrue(Str::startsWith($shortUrl, 'https://ouo.io/'));
    }
}
