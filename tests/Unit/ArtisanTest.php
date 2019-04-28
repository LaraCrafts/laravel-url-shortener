<?php

namespace LaraCrafts\UrlShortener\Tests\Unit;

use LaraCrafts\UrlShortener\Console\Commands\ShortenCommand;
use LaraCrafts\UrlShortener\UrlShortenerManager;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Str;
use Symfony\Component\Console\Tester\CommandTester;

class ArtisanTest extends TestCase
{
    /** @var \Mockery\MockInterface */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->shortener = \Mockery::mock(UrlShortenerManager::class);
    }

    public function testIfShortenShortensGivenUrl()
    {
        $commandTest = new CommandTester($this->shortenCommand());

        $url = Str::random(20);
        $shortUrl = substr($url, 0, 10);
        $driver = Str::random(5);

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

        $commandTest->execute([
            'url' => $url,
            '--driver' => $driver,
        ]);

        $this->assertRegExp("/Your short URL is: $shortUrl/", $commandTest->getDisplay());
    }

    public function testIfShortenUsesUrlFromInput()
    {
        $commandTester = new CommandTester($this->shortenCommand());

        $url = Str::random(20);
        $shortUrl = substr($url, 0, 10);
        $driver = Str::random(5);

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

        $commandTester->setInputs([
            $url
        ]);

        $commandTester->execute([
            '--driver' => $driver
        ]);
        $this->assertRegExp("/Your short URL is: $shortUrl/", $commandTester->getDisplay());
    }

    public function testIfShortenFailsIfNoUrlInput()
    {
        $commandTester = new CommandTester($this->shortenCommand());

        $this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);

        $this->shortener
            ->shouldNotReceive('driver');

        $this->shortener
            ->shouldNotReceive('shorten');

        $commandTester->execute([]);
    }

    protected function shortenCommand()
    {
        $command = new ShortenCommand($this->shortener);

        $command->setLaravel($this->app);

        return $command;
    }
}
