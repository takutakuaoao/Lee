<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Live;

use Lee\Live\Shared\ValueObject;

final class LiveName implements ValueObject
{
    public function __construct(private string $value)
    {
    }

    public function equal(ValueObject $value): bool
    {
        return get_class($this) === get_class($value) && $this->value === $value->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
