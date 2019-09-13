<?php

namespace LaraCrafts\UrlShortener\Concerns;

use LaraCrafts\UrlShortener\Builder;

interface WithSuffixes
{
    /**
     * Apply the given suffix.
     *
     * @param \LaraCrafts\UrlShortener\Builder $builder
     * @param string $suffix
     * @return void
     */
    public function applySuffix(Builder $builder, string $suffix): void;
}
