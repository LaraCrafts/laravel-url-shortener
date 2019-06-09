<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use GuzzleHttp\Exception\ClientException;
use LaraCrafts\UrlShortener\Http\PolrShortener;
use LaraCrafts\UrlShortener\Http\TinyUrlShortener;

class TinyUrlShortenerTest extends HttpTestCase
{
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

        $this->shortener = new TinyUrlShortener($this->client);
    }

    /**
     * Test shortening of URLs through TinyURL.
     *
     * @return void
     */
    public function testShorten()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/tiny_url/shorten.http-200.php');

        $shortenedUrl = $this->shortener->shorten('https://google.com');
        $request = $this->client->getRequest(0);

        $this->assertNotNull($request);
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('tinyurl.com', $request->getUri()->getHost());
        $this->assertEquals('/api-create.php?url=https%3A%2F%2Fgoogle.com', $request->getRequestTarget());
        $this->assertEquals('https://tinyurl.com/mbq3m', $shortenedUrl);
    }

    /**
     * Test failure of shortening through TinyURL.
     *
     * @return void
     * @depends testShorten
     */
    public function testFailure()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/tiny_url/shorten.http-400.php');

        $this->expectException(ClientException::class);
        $this->shortener->shorten('https://google.com');
    }
}
