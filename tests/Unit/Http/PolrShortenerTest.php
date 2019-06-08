<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use LaraCrafts\UrlShortener\Http\PolrShortener;
use LaraCrafts\UrlShortener\Tests\Concerns\HasUrlAssertions;
use Orchestra\Testbench\TestCase;

class PolrShortenerTest extends TestCase
{
    use HasUrlAssertions;

    /**
     * @var \LaraCrafts\UrlShortener\Http\PolrShortener
     */
    protected $shortener;

    /**
     * @var array
     */
    private $history;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->history = [];

        $handler = new MockHandler([
            new Response(200, [], '{"action": "shorten","result": "https://example.com/5kq"}'),
        ]);

        $stack = HandlerStack::create($handler);
        $stack->push(Middleware::history($this->history));

        $client = new Client(['handler' => $stack]);
        $this->shortener = new PolrShortener($client, 'API_KEY', 'http://example.com');
    }

    /**
     * Test Polr synchronous shortening.
     *
     * @return void
     */
    public function testShorten()
    {
        $shortUrl = $this->shortener->shorten('https://google.com');

        $this->assertCount(1, $this->history);

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->history[0]['request'];
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'http://example.com/api/v2/action/shorten?key=API_KEY&response_type=json&url=https%3A%2F%2Fgoogle.com',
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

        $this->assertCount(1, $this->history);

        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $this->history[0]['request'];
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'http://example.com/api/v2/action/shorten?key=API_KEY&response_type=json&url=https%3A%2F%2Fgoogle.com',
            $request->getUri()->__toString()
        );

        $this->assertValidUrl($shortUrl);
        $this->assertEquals('https://example.com/5kq', $shortUrl);
    }
}
