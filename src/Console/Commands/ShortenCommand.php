<?php

namespace LaraCrafts\UrlShortener\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ShortenCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'shorten';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shorten a given URL';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $driver = $this->laravel['url.shortener']->driver($this->input->getOption('driver'));

        $shortUrl = $driver->shorten($this->input->getArgument('url'));

        $this->info('URL shortened successfully.');
        $this->info("Your short URL is: $shortUrl");
    }

    /**
     * {@inheritDoc}
     */
    protected function getArguments()
    {
        return [
            ['url', InputArgument::REQUIRED, 'The URL to shorten'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getOptions()
    {
        return [
            ['driver', 'D', InputOption::VALUE_REQUIRED, 'The driver to use for shortening the given URL'],
        ];
    }
}
