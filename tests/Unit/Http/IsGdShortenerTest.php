<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use GuzzleHttp\Exception\ClientException;
use LaraCrafts\UrlShortener\Http\IsGdShortener;

class IsGdShortenerTest extends HttpTestCase
{
    /**
     * @var \LaraCrafts\UrlShortener\Http\IsGdShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->shortener = new IsGdShortener($this->client, 'https://is.gd', false);
    }

    /**
     * Test the shortening of URLs through is.gd
     *
     * @return void
     */
    public function testShortening()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/is.gd/shorten.http-200.php');

        $shortenedUrl = $this->shortener->shorten('https://google.com');
        $request = $this->client->getRequest(0);

        $this->assertNotNull($request);
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('is.gd', $request->getUri()->getHost());

        $this->assertEquals(
            '/create.php?format=simple&logstats=0&url=https%3A%2F%2Fgoogle.com',
            $request->getRequestTarget()
        );

        $this->assertEquals('https://is.gd/jAxBiv', $shortenedUrl);
    }

    /**
     * Test failure of shortening through is.gd.
     *
     * @return void
     * @depends testShortening
     */
    public function testFailure()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/is.gd/shorten.http-400.php');

        $this->expectException(ClientException::class);
        $this->shortener->shorten('https://google.com');
    }
}
