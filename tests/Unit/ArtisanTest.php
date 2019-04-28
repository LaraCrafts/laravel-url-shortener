<?php

namespace LaraCrafts\UrlShortener\Tests\Unit;

use LaraCrafts\UrlShortener\Console\Commands\ShortenCommand;
use LaraCrafts\UrlShortener\UrlShortenerManager;
use Orchestra\Testbench\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class ArtisanTest extends TestCase
{
    /** @var \Symfony\Component\Console\Output\BufferedOutput */
    protected $output;

    /** @var \Mockery\MockInterface */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->output = new BufferedOutput();
        $this->shortener = \Mockery::mock(UrlShortenerManager::class);
        $this->app['url.shortener'] = $this->shortener;
    }

    public function testShortenCommand()
    {
        $command = new ShortenCommand();

        $command->setLaravel($this->app);

        $url = str_random(20);
        $shortUrl = substr($url, 0, 10);
        $driver = str_random(5);

        $this->shortener
            ->shouldReceive('driver')
            ->once()
            ->with($driver)
            ->andReturn($this->shortener);

        $this->shortener
            ->shouldReceive('shorten')
            ->once()
            ->with($url)
            ->andReturn($shortUrl);

        $command->run(new ArrayInput([
            'url' => $url,
            '--driver' => $driver,
        ]), $this->output);

        $this->assertRegExp("/Your short URL is: $shortUrl/", $this->output->fetch());
    }
}
