<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use GuzzleHttp\Exception\ClientException;
use LaraCrafts\UrlShortener\Http\ShorteStShortener;

class ShorteStShortenerTest extends HttpTestCase
{
    /**
     * @var \LaraCrafts\UrlShortener\Http\ShorteStShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->shortener = new ShorteStShortener($this->client, 'API_TOKEN');
    }

    /**
     * Test shortening of URLs through Shorte.st.
     *
     * @return void
     */
    public function testShorten()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/shorte_st/shorten.http-200.php');

        $this->shortener->shorten('https://google.com');
        $request = $this->client->getRequest(0);

        $this->assertNotNull($request);
        $this->assertEquals('PUT', $request->getMethod());
        $this->assertEquals('api.shorte.st', $request->getUri()->getHost());
        $this->assertEquals('/v1/data/url', $request->getRequestTarget());
        $this->assertEquals('API_TOKEN', $request->getHeader('Public-API-Token')[0]);
        $this->assertEquals('urlToShorten=https%3A%2F%2Fgoogle.com', $request->getBody()->getContents());
    }

    /**
     * Test failure of shortening through Shorte.st.
     *
     * @return void
     * @depends testShorten
     */
    public function testFailure()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/shorte_st/shorten.http-400.php');

        $this->expectException(ClientException::class);
        $this->shortener->shorten('https://google.com');
    }
}
