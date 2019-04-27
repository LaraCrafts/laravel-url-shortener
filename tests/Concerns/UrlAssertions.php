<?php

namespace LaraCrafts\UrlShortener\Tests\Concerns;

use LaraCrafts\UrlShortener\Tests\Constraints\IsValidUrl;
use LaraCrafts\UrlShortener\Tests\Constraints\RedirectsTo;

trait CustomAssertions
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

    public static function isValidUrl(): IsValidUrl
    {
        return new IsValidUrl;
    }

    public static function redirectsTo($expected, int $redirects = 1): RedirectsTo
    {
        return new RedirectsTo($expected, $redirects);
    }
}
