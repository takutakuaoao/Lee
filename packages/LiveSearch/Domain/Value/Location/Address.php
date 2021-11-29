<?php

namespace Lee\LiveSearch\Domain\Value\Location;

use InvalidArgumentException;

class Address
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

    public function __toString()
    {
        return $this->value;
    }
}
