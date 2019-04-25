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
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->app['config']['url-shortener'] = require __DIR__ . '/../../config/url-shortener.php';
        $this->app['config']['url-shortener.drivers.bit_ly.token'] = Str::random(32);
        $this->app['config']['url-shortener.drivers.firebase.token'] = Str::random(32);
        $this->app['config']['url-shortener.drivers.firebase.prefix'] = Str::random(32).'.com';
        $this->app['config']['url-shortener.drivers.ouo_io.token'] = Str::random(32);
        $this->app['config']['url-shortener.drivers.shorte_st.token'] = Str::random(32);

        $this->app->bind(ClientInterface::class, Client::class);
        $this->manager = new UrlShortenerManager($this->app);
    }

    /**
     * Test Bit.ly driver creation.
     *
     * @return void
     */
    public function testBitLyDriverCreation()
    {
        $driver = $this->manager->driver('bit_ly');
        $this->assertInstanceOf(BitLyShortener::class, $driver);
    }

    /**
     * Test the default driver creation.
     *
     * @return void
     */
    public function testDefaultDriverCreation()
    {
        $this->app['config']['url-shortener.default'] = 'tiny_url';
        $driver = $this->manager->driver();

        $this->assertInstanceOf(TinyUrlShortener::class, $driver);
    }

    /**
     * Test Firebase driver creation.
     *
     * @return void
     */
    public function testFirebaseDriverCreation()
    {
        $driver = $this->manager->driver('firebase');
        $this->assertInstanceOf(FirebaseShortener::class, $driver);
    }

    /**
     * Test Is.gd driver creation.
     *
     * @return void
     */
    public function testIsGdDriverCreation()
    {
        $driver = $this->manager->driver('is_gd');
        $this->assertInstanceOf(IsGdShortener::class, $driver);
    }

    /**
     * Test Ouo.io driver creation.
     *
     * @return void
     */
    public function testOuoIoDriverCreation()
    {
        $driver = $this->manager->driver('ouo_io');
        $this->assertInstanceOf(OuoIoShortener::class, $driver);
    }

    /**
     * Test Shorte.st driver creation.
     *
     * @return void
     */
    public function testShorteStDriverCreation()
    {
        $driver = $this->manager->driver('shorte_st');
        $this->assertInstanceOf(ShorteStShortener::class, $driver);
    }

    /**
     * Test TinyURL driver creation.
     *
     * @return void
     */
    public function testTinyUrlDriverCreation()
    {
        $driver = $this->manager->driver('tiny_url');
        $this->assertInstanceOf(TinyUrlShortener::class, $driver);
    }
}
