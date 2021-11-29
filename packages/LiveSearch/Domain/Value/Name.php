<?php

namespace Lee\LiveSearch\Domain\Value;

use InvalidArgumentException;

class Name
{
    private const MAX_LENGTH = 100;

    /** @var string */
    private $value;

    /**
     * @param string $name
     * @throws InvalidArgumentException
     */
    public function __construct(string $name)
    {
        $name = trim($name);

        if ($name === '' || mb_strlen($name) > self::MAX_LENGTH) {
            throw new InvalidArgumentException('$name is empty.');
        }

        $this->value = $name;
    }

    public function __toString()
    {
        return $this->value;
    }
}
