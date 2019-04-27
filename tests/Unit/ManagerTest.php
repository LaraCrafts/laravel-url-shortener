<?php

namespace LaraCrafts\UrlShortener\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Str;
use LaraCrafts\UrlShortener\Http\BitLyShortener;
use LaraCrafts\UrlShortener\Http\FirebaseShortener;
use LaraCrafts\UrlShortener\Http\IsGdShortener;
use LaraCrafts\UrlShortener\Http\OuoIoShortener;
use LaraCrafts\UrlShortener\Http\ShorteStShortener;
use LaraCrafts\UrlShortener\Http\TinyUrlShortener;
use LaraCrafts\UrlShortener\UrlShortenerManager;
use Orchestra\Testbench\TestCase;

class ManagerTest extends TestCase
{
    /**
     * @var \LaraCrafts\UrlShortener\UrlShortenerManager
     */
    protected $manager;

    /**
     * Provider driver data.
     *
     * @return array
     */
    public function driverProvider()
    {
        return [
            'Default' => [null, TinyUrlShortener::class],
            'Bit.ly' => ['bit_ly', BitLyShortener::class],
            'Firebase' => ['firebase', FirebaseShortener::class],
            'Is.gd' => ['is_gd', IsGdShortener::class],
            'Ouo.io' => ['ouo_io', OuoIoShortener::class],
            'Shorte.st' => ['shorte_st', ShorteStShortener::class],
            'TinyURL' => ['tiny_url', TinyUrlShortener::class],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->app['config']['url-shortener'] = require __DIR__ . '/../../config/url-shortener.php';
        $this->app['config']['url-shortener.drivers.bit_ly.token'] = Str::random(32);
        $this->app['config']['url-shortener.drivers.firebase.token'] = Str::random(32);
        $this->app['config']['url-shortener.drivers.firebase.prefix'] = Str::random(32) . '.com';
        $this->app['config']['url-shortener.drivers.ouo_io.token'] = Str::random(32);
        $this->app['config']['url-shortener.drivers.shorte_st.token'] = Str::random(32);

        $this->app->bind(ClientInterface::class, Client::class);
        $this->manager = new UrlShortenerManager($this->app);
    }

    /**
     * @param string|null $driver
     * @param string $expected
     * @return void
     * @dataProvider driverProvider
     */
    public function testDriverCreation(?string $driver, string $expected)
    {
        $this->assertInstanceOf($expected, $this->manager->driver($driver));
    }
}
