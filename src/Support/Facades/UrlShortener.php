<?php

namespace LaraCrafts\UrlShortener\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \LaraCrafts\UrlShortener\Contracts\Shortener driver(string $driver = null)
 * @method static void extend(string $driver, \Closure $callback)
 * @method static string shorten(string $url, array $options = [])
 * @method static \GuzzleHttp\Promise\PromisorInterface shortenAsync(string $driver, string $url, array $options = [])
 * @method static string shortenUsing(string $driver, string $url, array $options = [])
 * @method static \GuzzleHttp\Promise\PromisorInterface shortenAsyncUsing(string $driver, string $url, array $options = [])
 *
 * @see \LaraCrafts\UrlShortener\Contracts\Shortener
 * @see \LaraCrafts\UrlShortener\UrlShortenerManager
 */
class UrlShortener extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'url.shortener';
    }
}
