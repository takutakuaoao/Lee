<?php

declare(strict_types=1);

namespace Lee\Live\Shared;

interface ValueObject
{
    public function equal(ValueObject $value): bool;
    public function __toString(): string;
}
