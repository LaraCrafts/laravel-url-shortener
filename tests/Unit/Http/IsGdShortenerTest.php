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
     * Test the shortening of URLs.
     *
     * @return void
     */
    public function testShorten()
    {
        $this->client->queue(
            require __DIR__ . '/../../Fixtures/is.gd/shorten.http-200.php',
            require __DIR__ . '/../../Fixtures/is.gd/shorten.http-400.php'
        );

        $this->assertEquals('https://is.gd/jAxBiv', $this->shortener->shorten('https://google.com'));

        $this->expectException(ClientException::class);
        $this->shortener->shorten('https://google.com');
    }
}
