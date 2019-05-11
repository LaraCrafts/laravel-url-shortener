<?php

namespace LaraCrafts\UrlShortener\Http;

use LaraCrafts\UrlShortener\Contracts\Shortener;

abstract class RemoteShortener implements Shortener
{
    /**
     * {@inheritDoc}
     */
    public function shorten($url, array $options = [])
    {
        return $this->shortenAsync($url, $options)->wait();
    }
}
