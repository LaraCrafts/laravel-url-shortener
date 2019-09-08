<?php

namespace LaraCrafts\UrlShortener\Tests;

use Faker\Factory;
use LaraCrafts\UrlShortener\Builder;
use LaraCrafts\UrlShortener\Concerns\WithSuffixes;
use LaraCrafts\UrlShortener\Contracts\Client;
use LaraCrafts\UrlShortener\Contracts\UnsupportedOperationException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use stdClass;

class BuilderTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface|\LaraCrafts\UrlShortener\Contracts\Client
     */
    protected $client;

    /**
     * @var \Faker\Generator;
     */
    protected $faker;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->client = Mockery::mock(Client::class);
        $this->faker = Factory::create();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * Test the adding of custom options.
     *
     * @return void
     */
    public function testAddingOptions()
    {
        $builder = new Builder($this->client, $this->faker->url, []);

        $builder->with('foo', 'bar');
        $this->assertEquals(['foo' => 'bar'], $builder->getOptions());

        $builder->with(['baz' => 'qux']);
        $this->assertEquals(['foo' => 'bar', 'baz' => 'qux'], $builder->getOptions());
    }

    /**
     * Test the construction of a new Builder instance.
     *
     * @return void
     */
    public function testConstructor()
    {
        $builder = new Builder($this->client, $uri = $this->faker->url, ['foo' => 'bar']);

        $this->assertSame($this->client, $builder->getClient());
        $this->assertInstanceOf(UriInterface::class, $builder->getUri());
        $this->assertEquals($uri, (string)$builder->getUri());
        $this->assertEquals(['foo' => 'bar'], $builder->getOptions());
    }

    /**
     * Test the applying of suffixes.
     *
     * @return void
     * @doesNotPerformAssertions
     */
    public function testSuffixes()
    {
        $builder = new Builder($this->client, $this->faker->url, []);
        $driver = Mockery::mock(WithSuffixes::class);
        $suffix = $this->faker->asciify('******');

        $this->client
            ->shouldReceive('driver')
            ->once()
            ->andReturn($driver);

        $driver
            ->shouldReceive('applySuffix')
            ->once()
            ->with($builder, $suffix)
            ->andReturnNull();

        $builder->toSuffix($suffix);
    }

    /**
     * Test the applying of suffixes on a driver that does not support it.
     *
     * @return void
     */
    public function testSuffixesUnsupported()
    {
        $builder = new Builder($this->client, $this->faker->url, []);
        $driver = new stdClass();
        $suffix = $this->faker->asciify('******');

        $this->client
            ->shouldReceive('driver')
            ->once()
            ->andReturn($driver);

        $this->expectException(UnsupportedOperationException::class);
        $this->expectExceptionMessage('Applying a custom suffix is not supported');

        $builder->toSuffix($suffix);
    }
}
