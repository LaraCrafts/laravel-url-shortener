<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use GuzzleHttp\Exception\ClientException;
use LaraCrafts\UrlShortener\Http\BitLyShortener;

class BitLyShortenerTest extends HttpTestCase
{
    /**
     * @var \LaraCrafts\UrlShortener\Http\BitLyShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->shortener = new BitLyShortener($this->client, 'API_TOKEN', false);
    }

    /**
     * Test the shortening of URLs through Bit.ly.
     *
     * @return void
     */
    public function testShortening()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/bit_ly/shorten.http-200.php');

        $shortenedUrl = $this->shortener->shorten('https://google.com');
        $request = $this->client->getRequest(0);

        $this->assertNotNull($request);
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('api-ssl.bitly.com', $request->getUri()->getHost());
        $this->assertEquals('/v4/shorten', $request->getRequestTarget());
        $this->assertEquals('Bearer API_TOKEN', $request->getHeader('Authorization')[0]);
        $this->assertEquals('application/json', $request->getHeader('Content-Type')[0]);

        $this->assertEquals('https://bit.ly/2WujBe0', $shortenedUrl);
    }

    /**
     * Test failure to authenticate with Bit.ly.
     *
     * @return void
     * @depends testShortening
     */
    public function testUnauthorized()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/bit_ly/shorten.http-403.php');

        $this->expectException(ClientException::class);
        $this->shortener->shorten('https://google.com');
    }
}
