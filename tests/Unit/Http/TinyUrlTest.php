<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use LaraCrafts\UrlShortener\Http\TinyUrl;

class TinyUrlTest extends TestCase
{
    /**
     * Test URL shortening.
     *
     * @return void
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function testUrlGeneration()
    {
        $driver = new TinyUrl($this->httpClient, $this->requestFactory);
        $longUrl = $this->uriFactory->createUri('https://google.com');

        $this->queueHttpResponse(function () {
            return 'https://tinyurl.com/mbq3m';
        });

        $shortUrl = $driver->toString($longUrl, []);
        $this->assertEquals('https://tinyurl.com/mbq3m', $shortUrl);
    }
}
