<?php

namespace LaraCrafts\UrlShortener\Tests\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

class IsValidUrl extends Constraint
{

    /**
     * Returns a string representation of the object.
     */
    public function toString(): string
    {
        return 'is valid URL';
    }

    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param mixed $other value or object to evaluate
     * @return bool
     */
    protected function matches($other): bool
    {
        return filter_var($other, FILTER_VALIDATE_URL);
    }
}
