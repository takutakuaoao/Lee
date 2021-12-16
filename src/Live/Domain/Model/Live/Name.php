<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Live;

use InvalidArgumentException;
use Lee\Live\Shared\ValueObject;

class Name implements ValueObject
{
    private const MAX_LENGTH = 100;

    /** @var string */
    private $value;

    /**
     * @param  string                   $name
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

    public function equal(ValueObject $value): bool
    {
        return get_class($this) === get_class($value) && $this->value === $value->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
