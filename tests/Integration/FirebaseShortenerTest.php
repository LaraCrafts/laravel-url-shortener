<?php

namespace LaraCrafts\UrlShortener\Tests\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use LaraCrafts\UrlShortener\Http\FirebaseShortener;
use Orchestra\Testbench\TestCase;

class FirebaseShortenerTest extends TestCase
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $prefix;

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

        $this->token = $token;
        $this->prefix = $prefix;
    }

    public function suffixProvider()
    {
        return [
            'Short' => ['SHORT'],
            'Unguessable' => ['UNGUESSABLE'],
        ];
    }

    /**
     * Test Firebase synchronous shortening.
     *
     * @param string $suffix
     * @return void
     * @dataProvider suffixProvider
     */
    public function testShorten(string $suffix)
    {
        $shortener = new FirebaseShortener(new Client, $this->token, $this->prefix, $suffix);
        $shortUrl = $shortener->shorten('https://google.com');

        $this->assertInternalType('string', $shortUrl);
    }

    /**
     * Test Firebase asynchronous shortening.
     *
     * @param string $suffix
     * @return void
     * @dataProvider suffixProvider
     */
    public function testShortenAsync(string $suffix)
    {
        $shortener = new FirebaseShortener(new Client, $this->token, $this->prefix, $suffix);
        $promise = $shortener->shortenAsync('https://google.com');

        $this->assertInstanceOf(PromiseInterface::class, $promise);
        $this->assertInternalType('string', $promise->wait());
    }
}
