<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use LaraCrafts\UrlShortener\Http\OuoIoShortener;

class OuoIoShortenerTest extends HttpTestCase
{
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

        $this->shortener = new OuoIoShortener($this->client, 'API_KEY');
    }

    /**
     * Test shortening of URLs through Ouo.io.
     *
     * @return void
     */
    public function testShorten()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/ouo_io/shorten.http-200.php');

        $shortenedUrl = $this->shortener->shorten('https://google.com');
        $request = $this->client->getRequest(0);

        $this->assertNotNull($request);
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('ouo.io', $request->getUri()->getHost());
        $this->assertEquals('/api/API_KEY?s=https%3A%2F%2Fgoogle.com', $request->getRequestTarget());
        $this->assertEquals('https://ouo.io/lpfqW3o', $shortenedUrl);
    }
}
