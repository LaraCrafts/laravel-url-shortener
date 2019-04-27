<?php

namespace LaraCrafts\UrlShortener\Tests\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Str;
use LaraCrafts\UrlShortener\Http\IsGdShortener;
use LaraCrafts\UrlShortener\Tests\Concerns\CustomAssertions;
use Orchestra\Testbench\TestCase;

class VGdShortenerTest extends TestCase
{
    use CustomAssertions;

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
        $this->shortener = new IsGdShortener(new Client, true, false);
    }

    /**
     * Test Is.gd synchronous shortening.
     *
     * @return void
     */
    public function testShorten()
    {
        $shortUrl = $this->shortener->shorten('https://google.com');

        $this->assertValidUrl($shortUrl);
        $this->assertTrue(Str::startsWith($shortUrl, 'https://v.gd'));
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
        $this->assertValidUrl($shortUrl = $promise->wait());
        $this->assertTrue(Str::startsWith($shortUrl, 'https://v.gd'));
    }
}
