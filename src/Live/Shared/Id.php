<?php

namespace Lee\Live\Shared;

use InvalidArgumentException;

class Id implements ValueObject
{
    public function __construct(
        protected int $value,
    ) {
        if ($value < 1) {
            throw new InvalidArgumentException('ID must is over 1.');
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equal(ValueObject $value): bool
    {
        return get_class($this) === get_class($value) && $this->value === $value->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
