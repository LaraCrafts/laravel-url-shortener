<?php

namespace LaraCrafts\UrlShortener\Tests\Concerns;

use LaraCrafts\UrlShortener\Tests\Constraints\RedirectsTo;

trait FollowsRedirects
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
        static::assertThat($actual, new RedirectsTo($expected, $redirects));
    }
}
