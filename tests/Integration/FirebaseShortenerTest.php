<?php

namespace LaraCrafts\UrlShortener\Tests\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use LaraCrafts\UrlShortener\Http\FirebaseShortener;
use LaraCrafts\UrlShortener\Tests\Concerns\HasUrlAssertions;
use PHPUnit\Framework\TestCase;

class FirebaseShortenerTest extends TestCase
{
    use HasUrlAssertions;

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

        if (!$token = getenv('FIREBASE_API_TOKEN')) {
            $this->markTestSkipped('No Firebase API token set');
        }

        if (!$prefix = getenv('FIREBASE_URI_PREFIX')) {
            $this->markTestSkipped('No Firebase URI prefix set');
        }

        $this->token = $token;
        $this->prefix = $prefix;
    }

    /**
     * Provide suffix data.
     *
     * @return array
     */
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

        $this->assertValidUrl($shortUrl);
        $this->assertRedirectsTo('https://google.com', $shortUrl, 1);
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
        $this->assertValidUrl($shortUrl = $promise->wait());
        $this->assertRedirectsTo('https://google.com', $shortUrl, 1);
    }
}
