<?php

namespace LaraCrafts\UrlShortener\Console\Commands;

use Illuminate\Console\Command;
use LaraCrafts\UrlShortener\UrlShortenerManager;

class ShortenCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'url:shorten
                            {url? : The URL to shorten}
                            {--D|driver= : The driver to use to shorten the URL.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shorten a given URL';

    /**
     * The URL Shortener instance.
     *
     * @var \LaraCrafts\UrlShortener\UrlShortenerManager
     */
    protected $shortener;

    /**
     * Create a new ShortenCommand instance.
     *
     * @param \LaraCrafts\UrlShortener\UrlShortenerManager $shortener
     */
    public function __construct(UrlShortenerManager $shortener)
    {
        parent::__construct();

        $this->shortener = $shortener;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->argument('url') ?? $this->ask('Please enter the URL to shorten');

        if (!$url) {
            return $this->error('Aborted: No URL was given.');
        }

        $driver = $this->shortener->driver($this->option('driver'));

        $shortUrl = $driver->shorten($url);

        $this->info('URL shortened successfully.');
        $this->info("Your short URL is: $shortUrl");
    }
}
