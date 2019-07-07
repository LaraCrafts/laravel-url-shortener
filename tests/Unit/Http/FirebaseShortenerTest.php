<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use GuzzleHttp\Exception\ClientException;
use LaraCrafts\UrlShortener\Http\FirebaseShortener;

class FirebaseShortenerTest extends HttpTestCase
{
    /**
     * @var \LaraCrafts\UrlShortener\Http\FirebaseShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->shortener = new FirebaseShortener($this->client, 'API_TOKEN', 'URI_PREFIX', 'SHORT');
    }

    /**
     * Test the shortening of URLs through Firebase.
     *
     * @return void
     */
    public function testShortening()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/firebase/shorten.http-200.php');

        $shortenedUrl = $this->shortener->shorten('https://google.com');
        $request = $this->client->getRequest(0);

        $this->assertNotNull($request);
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('firebasedynamiclinks.googleapis.com', $request->getUri()->getHost());
        $this->assertEquals('/v1/shortLinks?key=API_TOKEN', $request->getRequestTarget());
        $this->assertEquals('application/json', $request->getHeader('Content-Type')[0]);
        $this->assertEquals('application/json', $request->getHeader('Accept')[0]);

        $expected = '{"dynamicLinkInfo":{"domainUriPrefix":"URI_PREFIX","link":"https:\/\/google.com"},"suffix":{"option":"SHORT"}}';
        $this->assertJsonStringEqualsJsonString($expected, $request->getBody()->getContents());

        $this->assertEquals('https://laracrafts.page.link/NLtk', $shortenedUrl);
    }

    /**
     * Test failure to authenticate with Firebase.
     *
     * @return void
     * @depends testShortening
     */
    public function testUnauthorized()
    {
        $this->client->queue(require __DIR__ . '/../../Fixtures/firebase/shorten.http-400.php');

        $this->expectException(ClientException::class);
        $this->shortener->shorten('https://google.com');
    }
}
