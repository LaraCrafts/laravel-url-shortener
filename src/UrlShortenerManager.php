<?php

namespace LaraCrafts\UrlShortener;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
use LaraCrafts\UrlShortener\Contracts\Factory;
use LaraCrafts\UrlShortener\Http\BitLyShortener;
use LaraCrafts\UrlShortener\Http\FirebaseShortener;
use LaraCrafts\UrlShortener\Http\IsGdShortener;
use LaraCrafts\UrlShortener\Http\OuoIoShortener;
use LaraCrafts\UrlShortener\Http\ShorteStShortener;
use LaraCrafts\UrlShortener\Http\TinyUrlShortener;

/**
 * @mixin \LaraCrafts\UrlShortener\Contracts\Shortener
 */
class UrlShortenerManager extends Manager implements Factory
{
    /**
     * Create an instance of the Bit.ly driver.
     *
     * @return \LaraCrafts\UrlShortener\Http\BitLyShortener
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function createBitLyDriver()
    {
        $config = $this->getDriverConfig('bit_ly');

        return new BitLyShortener(
            $this->app->make(ClientInterface::class),
            Arr::get($config, 'token'),
            Arr::get($config, 'domain', 'bit.ly')
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function createDriver($driver)
    {
        # This fixes backwards compatibility issues with this function
        if (method_exists($this, $method = 'create' . Str::studly($driver) . 'Driver')) {
            return $this->$method();
        }

        return parent::createDriver($driver);
    }

    /**
     * Create an instance of the Firebase driver.
     *
     * @return \LaraCrafts\UrlShortener\Http\FirebaseShortener
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function createFirebaseDriver()
    {
        $config = $this->getDriverConfig('firebase');

        return new FirebaseShortener(
            $this->app->make(ClientInterface::class),
            Arr::get($config, 'token'),
            Arr::get($config, 'prefix'),
            Arr::get($config, 'suffix')
        );
    }

    /**
     * Create an instance of the Is.gd driver.
     *
     * @return \LaraCrafts\UrlShortener\Http\IsGdShortener
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function createIsGdDriver()
    {
        $config = $this->getDriverConfig('is_gd');

        return new IsGdShortener(
            $this->app->make(ClientInterface::class),
            Arr::get($config, 'base_uri'),
            Arr::get($config, 'statistics')
        );
    }

    /**
     * Create an instance of the Ouo.io driver.
     *
     * @return \LaraCrafts\UrlShortener\Http\OuoIoShortener
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function createOuoIoDriver()
    {
        $config = $this->getDriverConfig('ouo_io');

        return new OuoIoShortener(
            $this->app->make(ClientInterface::class),
            Arr::get($config, 'token')
        );
    }

    /**
     * Create an instance of the Shorte.st driver.
     *
     * @return \LaraCrafts\UrlShortener\Http\ShorteStShortener
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function createShorteStDriver()
    {
        $config = $this->getDriverConfig('shorte_st');

        return new ShorteStShortener(
            $this->app->make(ClientInterface::class),
            Arr::get($config, 'token')
        );
    }

    /**
     * Create an instance of the TinyURL driver.
     *
     * @return \LaraCrafts\UrlShortener\Http\TinyUrlShortener
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function createTinyUrlDriver()
    {
        return new TinyUrlShortener($this->app->make(ClientInterface::class));
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['url-shortener.default'];
    }

    /**
     * Get the driver configuration.
     *
     * @param string $name
     * @return array
     */
    protected function getDriverConfig(string $name)
    {
        return $this->app['config']["url-shortener.shorteners.$name"] ?: [];
    }
}
