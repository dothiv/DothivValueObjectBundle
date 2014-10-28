<?php

namespace Dothiv\ValueObject;

interface ValueObjectInterface
{
    /**
     * Converts the ValueObject to a scalar value, which must be parseable by it again.
     *
     * @return string|integer|float|boolean
     */
    public function toScalar();

    /**
     * Returns the string representation of the ValueObject which must be parseable by it again.
     *
     * @return string
     */
    public function __toString();
} 
