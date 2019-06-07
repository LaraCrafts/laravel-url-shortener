<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use GuzzleHttp\Exception\ClientException;
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

        $this->shortener = new PolrShortener($this->client, 'API_KEY', 'http://example.com');
    }

    /**
     * Test shortening of URLs through Polr.
     *
     * @return void
     */
    public function testShorten()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/polr/shorten.http-200.php');

        $shortenedUrl = $this->shortener->shorten('https://google.com');
        $request = $this->client->getRequest(0);

        $this->assertNotNull($request);
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('example.com', $request->getUri()->getHost());

        $this->assertEquals(
            '/api/v2/action/shorten?key=API_KEY&response_type=json&url=https%3A%2F%2Fgoogle.com',
            $request->getRequestTarget()
        );

        $this->assertEquals('http://demo.polr.me/0', $shortenedUrl);
    }

    /**
     * Test failure of shortening through Polr.
     *
     * @return void
     * @depends testShorten
     */
    public function testFailure()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/polr/shorten.http-400.php');

        $this->expectException(ClientException::class);
        $this->shortener->shorten('https://google.com');
    }
}
