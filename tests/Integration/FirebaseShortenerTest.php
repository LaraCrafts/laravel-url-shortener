<?php

namespace LaraCrafts\UrlShortener\Tests\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use LaraCrafts\UrlShortener\Http\FirebaseShortener;
use Orchestra\Testbench\TestCase;

class FirebaseShortenerTest extends TestCase
{
    /**
     * @var \LaraCrafts\UrlShortener\Http\FirebaseShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        if (!$token = env('FIREBASE_API_TOKEN')) {
            $this->markTestSkipped('No Firebase API token set');
        }

        if (!$prefix = env('FIREBASE_URI_PREFIX')) {
            $this->markTestSkipped('No Firebase URI prefix set');
        }

        $this->shortener = new FirebaseShortener(new Client, $token, $prefix, 'SHORT');
    }

    /**
     * Test Shorte.st synchronous shortening.
     *
     * @return void
     */
    public function testShorten()
    {
        $shortUrl = $this->shortener->shorten('https://google.com');
        $this->assertInternalType('string', $shortUrl);
    }

    /**
     * Test Shorte.st asynchronous shortening.
     *
     * @return void
     */
    public function testShortenAsync()
    {
        $promise = $this->shortener->shortenAsync('https://google.com');

        $this->assertInstanceOf(PromiseInterface::class, $promise);
        $this->assertInternalType('string', $promise->wait());
    }
}