<?php

namespace LaraCrafts\UrlShortener\Tests\Unit;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Str;
use LaraCrafts\UrlShortener\UrlShortenerManager;
use LaraCrafts\UrlShortener\UrlShortenerServiceProvider;
use Orchestra\Testbench\TestCase;

class ProviderTest extends TestCase
{
    /**
     * {@inheritDoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            UrlShortenerServiceProvider::class,
        ];
    }

    public function testIfManagerIsBoundAsSingleton()
    {
        $this->assertEquals(
            $this->app->make('url.shortener'),
            $this->app->make(UrlShortenerManager::class)
        );
    }

    public function testUrlGeneratorMacros()
    {
        if (Str::contains($this->app->version(), 'Lumen')) {
            $this->markTestSkipped('Lumen doesn not support macros on UrlGenerator');
        }

        if (version_compare($this->app->version(), '5.2.0', '<')) {
            $this->markTestSkipped('Laravel 5.1 does not support macros on UrlGenerator');
        }

        $this->assertTrue(UrlGenerator::hasMacro('shorten'));
        $this->assertTrue(UrlGenerator::hasMacro('shortenAsync'));
        $this->assertTrue(UrlGenerator::hasMacro('shortener'));
    }
}
