<?php

namespace LaraCrafts\UrlShortener;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use LaraCrafts\UrlShortener\Support\Facades\UrlShortener;

class UrlShortenerServiceProvider extends ServiceProvider
{
    /**
     * Boot package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/url-shortener.php', 'url-shortener');
        $this->publishAssets();
        $this->registerMacros();

        UrlShortener::shortenUsing('bit_ly', 'https://google.com');
    }

    /**
     * Publish package assets.
     *
     * @return void
     */
    protected function publishAssets()
    {
        if (!$this->app->runningInConsole() || Str::contains($this->app->version(), 'Lumen')) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/url-shortener.php' => config_path('url-shortener.php'),
        ]);
    }

    /**
     * Register package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias('url.shortener', UrlShortenerManager::class);
        $this->app->bindIf(ClientInterface::class, Client::class);

        $this->app->singleton('url.shortener', function ($app) {
            return new UrlShortenerManager($app);
        });
    }

    /**
     * Register UrlGenerator macro's.
     *
     * @return void
     */
    protected function registerMacros()
    {
        if (!class_exists(UrlGenerator::class) || !method_exists(UrlGenerator::class, 'macro')) {
            return;
        }

        UrlGenerator::macro('shorten', function (...$parameters) {
            return app('url.shortener')->shorten(...$parameters);
        });

        UrlGenerator::macro('shortenAsync', function (...$parameters) {
            return app('url.shortener')->shortenAsync(...$parameters);
        });

        UrlGenerator::macro('shortenUsing', function (string $driver, ...$parameters) {
            return app('url.shortener')->shortenUsing($driver, ...$parameters);
        });

        UrlGenerator::macro('shortenAsyncUsing', function (string $driver, ...$parameters) {
            return app('url.shortener')->shortenAsyncUsing($driver, ...$parameters);
        });

        UrlGenerator::macro('shortener', function () {
            return app('url.shortener');
        });
    }
}
