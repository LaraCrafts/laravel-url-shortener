<?php

namespace LaraCrafts\UrlShortener\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Foundation\Application;
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
     * Provide driver data set.
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
            'V.gd' => ['v_gd', IsGdShortener::class],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->app['config']['url-shortener'] = require __DIR__ . '/../../config/url-shortener.php';
        $this->app['config']['url-shortener.shorteners.bit_ly.token'] = Str::random(32);
        $this->app['config']['url-shortener.shorteners.firebase.token'] = Str::random(32);
        $this->app['config']['url-shortener.shorteners.firebase.prefix'] = Str::random(32) . '.com';
        $this->app['config']['url-shortener.shorteners.ouo_io.token'] = Str::random(32);
        $this->app['config']['url-shortener.shorteners.shorte_st.token'] = Str::random(32);

        $this->app->bind(ClientInterface::class, Client::class);
        $this->manager = new UrlShortenerManager($this->app);
    }

    /**
     * Test custom driver creation.
     *
     * @return void
     */
    public function testCustomDriverCreation()
    {
        $reference = $this->app->make('stdClass');
        $testSuite = $this;

        $this->app['config']['url-shortener.shorteners.phpunit'] = ['driver' => 'phpunit'];

        $this->manager->extend('phpunit', function ($app, $config) use ($reference, $testSuite) {
            $testSuite->assertInstanceOf(Application::class, $app);
            $testSuite->assertInstanceOf(UrlShortenerManager::class, $this);
            $testSuite->assertIsArray($config);
            $testSuite->assertEquals(['driver' => 'phpunit'], $config);

            return $reference;
        });

        $this->assertSame($reference, $this->manager->driver('phpunit'));
    }

    /**
     * Test driver creation.
     *
     * @param string|null $driver
     * @param string $expected
     * @return void
     * @dataProvider driverProvider
     */
    public function testDriverCreation(?string $driver, string $expected)
    {
        $this->assertInstanceOf($expected, $this->manager->shortener($driver));
    }

    /**
     * Test the changing of the default driver.
     *
     * @return void
     */
    public function testDefaultDriver()
    {
        $expected = Str::random(32);

        $this->assertNotEquals($expected, $this->manager->getDefaultDriver());
        $this->manager->setDefaultDriver($expected);
        $this->assertEquals($expected, $this->manager->getDefaultDriver());
    }
}
