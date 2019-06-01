<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\choose_handler;

class HttpClient extends Client
{
    protected $handler;
    protected $history;

    /**
     * Create a new test client.
     *
     * @param array $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->handler = new MockHandler();
        $this->history = [];

        parent::__construct($config + ['handler' => $this->newHandlerStack($this->handler)]);
    }

    /**
     * Get the amount of messages waiting in the queue.
     *
     * @return int
     */
    public function getQueueSize()
    {
        return $this->handler->count();
    }

    /**
     * Determine if there are queued messages.
     *
     * @return bool
     */
    public function hasQueuedMessages()
    {
        return $this->getQueueSize() > 0;
    }

    /**
     * Get a fresh handler stack.
     *
     * @param callable|null $handler
     * @return \GuzzleHttp\HandlerStack
     */
    protected function newHandlerStack($handler = null)
    {
        $stack = new HandlerStack($handler ?: choose_handler());
        $stack->push(Middleware::history($this->history));
        $stack->push(Middleware::httpErrors());

        return $stack;
    }

    /**
     * Queue the given response.
     *
     * @param \Psr\Http\Message\ResponseInterface ...$responses
     * @return $this
     */
    public function queue(ResponseInterface ...$responses)
    {
        $this->handler->append(...$responses);

        return $this;
    }
}
