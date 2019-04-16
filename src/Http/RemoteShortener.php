<?php

namespace LaraCrafts\UrlShortener\Http;

use LaraCrafts\UrlShortener\Contracts\AsyncShortener;

abstract class RemoteShortener implements AsyncShortener
{
    /**
     * {@inheritDoc}
     */
    public function shorten($url, array $options = [])
    {
        return $this->shortenAsync($url, $options)->wait();
    }
}
