<?php

namespace LaraCrafts\UrlShortener\Concerns;

use LaraCrafts\UrlShortener\Builder;

interface CustomDomains
{
    /**
     * Apply the given domain to the builder.
     *
     * @param \LaraCrafts\UrlShortener\Builder $builder
     * @param string $domain
     * @return void
     */
    public function withDomain(Builder $builder, string $domain): void;
}
