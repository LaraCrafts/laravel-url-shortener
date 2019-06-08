<?php

namespace LaraCrafts\UrlShortener\Tests\Concerns;

use LaraCrafts\UrlShortener\Tests\Constraints\IsValidUrl;
use LaraCrafts\UrlShortener\Tests\Constraints\RedirectsTo;

trait HasUrlAssertions
{
    /**
     * Assert that the given value redirects to the expected value.
     *
     * @param \Psr\Http\Message\UriInterface|string $expected
     * @param \Psr\Http\Message\UriInterface|string $actual
     * @param int $redirects
     * @return void
     */
    public static function assertRedirectsTo($expected, $actual, int $redirects = 1)
    {
        static::assertThat($actual, static::redirectsTo($expected, $redirects));
    }

    /**
     * Assert that the given value is valid URL.
     *
     * @param mixed $actual
     */
    public static function assertValidUrl($actual)
    {
        static::assertThat($actual, static::isValidUrl());
    }

    /**
     * Create a IsValidUrl instance
     *
     * @return \LaraCrafts\UrlShortener\Tests\Constraints\IsValidUrl
     */
    public static function isValidUrl()
    {
        return new IsValidUrl;
    }

    /**
     * Create a RedirectsTo instance
     *
     * @param \Psr\Http\Message\UriInterface|string $expected
     * @param int $redirects
     * @return \LaraCrafts\UrlShortener\Tests\Constraints\RedirectsTo
     */
    public static function redirectsTo($expected, int $redirects = 1)
    {
        return new RedirectsTo($expected, $redirects);
    }
}
