<?php

namespace LaraCrafts\UrlShortener\Tests\Constraints;

use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use PHPUnit\Framework\Constraint\Constraint;

class RedirectsTo extends Constraint
{
    protected $client;
    protected $destination;
    protected $redirects;

    /**
     * Create a new RedirectsTo constraint.
     *
     * @param \Psr\Http\Message\UriInterface|string $destination
     * @param int $redirects
     * @return void
     */
    public function __construct($destination, int $redirects = 1)
    {
        parent::__construct();

        $this->client = new Client();
        $this->destination = rtrim($destination, '/');
        $this->redirects = $redirects;
    }

    /**
     * {@inheritDoc}
     */
    public function evaluate($other, $description = '', $returnResult = false)
    {
        $stack = [];

        $this->client->get($other, [
            'allow_redirects' => [
                'max' => max($this->redirects, 5),
            ],
            'on_stats' => function (TransferStats $stats) use (&$stack) {
                $stack[] = (string)$stats->getEffectiveUri();
            },
        ]);

        if (($actualRedirects = count($stack) - 1) < $this->redirects) {
            $this->fail($other, "Expected $this->redirects redirects, received $actualRedirects");
        }

        if (!$this->matches($actual = $stack[$this->redirects])) {
            $this->fail($actual, "Expected $this->destination, received $actual");
        }
    }

    /**
     * {@inheritDoc}
     */
    public function matches($other): bool
    {
        return rtrim($other, '/') === $this->destination;
    }

    /**
     * {@inheritDoc}
     */
    public function toString(): string
    {
        return 'redirects to ' . $this->destination;
    }
}
