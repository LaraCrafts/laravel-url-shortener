<?php

namespace LaraCrafts\UrlShortener\Tests\Constraints;

use PHPUnit\Framework\Constraint\Constraint;

class IsValidUrl extends Constraint
{
    /**
     * {@inheritDoc}
     */
    protected function matches($other): bool
    {
        return filter_var((string)$other, FILTER_VALIDATE_URL);
    }

    /**
     * {@inheritDoc}
     */
    public function toString(): string
    {
        return 'is a valid URL';
    }
}
