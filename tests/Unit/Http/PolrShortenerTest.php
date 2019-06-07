<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use LaraCrafts\UrlShortener\Http\PolrShortener;

class PolrShortenerTest extends HttpTestCase
{
    /**
     * @var \LaraCrafts\UrlShortener\Http\PolrShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->client->queue(
            new Response(200, [], '{"action": "shorten","result": "https://example.com/5kq"}')
        );

        $this->shortener = new PolrShortener($this->client, 'API_KEY', 'http://example.com');
    }

    /**
     * Test Polr synchronous shortening.
     *
     * @return void
     */
    public function testShorten()
    {
        $shortUrl = $this->shortener->shorten('https://google.com');

        $this->assertCount(1, $this->client->getHistory());

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->client->getHistory(0)['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'http://example.com/api/v2/action/shorten?key=API_KEY&url=https%3A%2F%2Fgoogle.com',
            $request->getUri()->__toString()
        );

        $this->assertValidUrl($shortUrl);
        $this->assertEquals('https://example.com/5kq', $shortUrl);
    }

    /**
     * Test Polr asynchronous shortening.
     *
     * @return void
     */
    public function testShortenAsync()
    {
        $promise = $this->shortener->shortenAsync('https://google.com');

        $this->assertInstanceOf(PromiseInterface::class, $promise);
        $shortUrl = $promise->wait();

        $this->assertCount(1, $this->client->getHistory());

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->client->getHistory(0)['request'];

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'http://example.com/api/v2/action/shorten?key=API_KEY&url=https%3A%2F%2Fgoogle.com',
            $request->getUri()->__toString()
        );

        $this->assertValidUrl($shortUrl);
        $this->assertEquals('https://example.com/5kq', $shortUrl);
    }
}
