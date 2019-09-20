<?php

namespace LaraCrafts\UrlShortener\Concerns;

use LaraCrafts\UrlShortener\Builder;

interface CustomSuffixes
{
    /**
     * Apply the given suffix to the builder.
     *
     * @param \LaraCrafts\UrlShortener\Builder $builder
     * @param string $suffix
     * @return void
     */
    public function withSuffix(Builder $builder, string $suffix): void;
}
