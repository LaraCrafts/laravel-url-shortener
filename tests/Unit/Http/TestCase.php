<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var \LaraCrafts\UrlShortener\Tests\Unit\Http\HttpClient
     */
    protected $client;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->client = new HttpClient();
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown(): void
    {
        if ($this->client->hasQueuedMessages()) {
            $this->fail(sprintf('HTTP client contains %d unused message(s)', $this->client->getQueueSize()));
        }

        parent::tearDown();
    }
}
