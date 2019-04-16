<?php

namespace LaraCrafts\UrlShortener\Tests\Concerns;

use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;

trait FollowsRedirects
{
    /**
     * Assert that given URL redirects to expected URL.
     *
     * @param \Psr\Http\Message\UriInterface|string $expected
     * @param \Psr\Http\Message\UriInterface|string $actual
     * @param int $redirects
     * @return void
     */
    public static function assertRedirectsTo($expected, $actual, int $redirects)
    {
        $client = new Client();
        $expected = rtrim($expected, '/');
        $stack = [];

        $client->get($actual, [
            'allow_redirects' => [
                'max' => max($redirects, 5),
            ],
            'on_stats' => function (TransferStats $stats) use (&$stack) {
                $stack[] = (string)$stats->getEffectiveUri();
            },
        ]);

        if (($actualRedirects = count($stack) - 1) < $redirects) {
            static::fail("Expected $redirects redirects, received $actualRedirects");
        }

        static::assertEquals($expected, rtrim($stack[$redirects], '/'));
    }
}
