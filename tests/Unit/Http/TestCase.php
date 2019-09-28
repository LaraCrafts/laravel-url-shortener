<?php

namespace LaraCrafts\UrlShortener\Tests\Unit\Http;

use Faker\Factory;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase as PHPUnit;
use Zend\Diactoros\CallbackStream;
use Zend\Diactoros\RequestFactory;
use Zend\Diactoros\ResponseFactory;
use Zend\Diactoros\UriFactory;

abstract class TestCase extends PHPUnit
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * @var \Http\Mock\Client
     */
    protected $httpClient;

    /**
     * @var \Zend\Diactoros\RequestFactory
     */
    protected $requestFactory;

    /**
     * @var \Zend\Diactoros\ResponseFactory
     */
    protected $responseFactory;

    /**
     * @var \Zend\Diactoros\UriFactory
     */
    protected $uriFactory;

    /**
     * Queue the given closure in the HTTP client.
     *
     * @param callable $response
     * @param int $status
     * @return void
     */
    protected function queueHttpResponse(callable $response, int $status = 200)
    {
        $this->httpClient->addResponse(
            $this->responseFactory->createResponse($status)->withBody(new CallbackStream($response))
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->faker = Factory::create();
        $this->httpClient = new Client();
        $this->requestFactory = new RequestFactory();
        $this->responseFactory = new ResponseFactory();
        $this->uriFactory = new UriFactory();
    }
}
