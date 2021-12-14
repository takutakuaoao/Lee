<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Live\LiveHouse;

use InvalidArgumentException;
use Lee\Live\Shared\ValueObject;

final class Address implements ValueObject
{
    /** @var string */
    private $value;

    public function __construct(string $address)
    {
        $address = trim($address);

        if ($address === '' || mb_strlen($address) > 500) {
            throw new InvalidArgumentException('Invalid address.');
        }

        $this->value = $address;
    }

    public function equal(ValueObject $value): bool
    {
        return get_class($this) === get_class($value) && $this->value === $value->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
