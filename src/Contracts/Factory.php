<?php

namespace LaraCrafts\UrlShortener\Contracts;

interface Factory
{
    /**
     * Get a shortener instance.
     *
     * @param string|null $name
     * @return \LaraCrafts\UrlShortener\Contracts\Shortener
     */
    public function shortener(string $name = null);
}
