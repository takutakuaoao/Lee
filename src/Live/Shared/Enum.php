<?php

declare(strict_types=1);

namespace Lee\Live\Shared;

use BadMethodCallException;
use Lee\Live\Shared\ValueObject;

use function Lee\snakeUpperCase;

use ReflectionClass;

abstract class Enum implements ValueObject
{
    protected function __construct(protected int $status)
    {
    }

    public function equal(ValueObject $value): bool
    {
        if (get_class($this) !== get_class($value)) {
            return false;
        }

        return $this->status === $value->status;
    }

    public function __toString(): string
    {
        return (string) $this->status;
    }

    public static function __callStatic($name, $arguments)
    {
        $reflection = new ReflectionClass(static::class);
        $constName  = snakeUpperCase($name);
        $constList  = $reflection->getConstants();

        if (!$reflection->hasConstant($constName)) {
            throw new BadMethodCallException('Factory method of enum must be has same const keyword.');
        }

        return new static($constList[$constName]);
    }

    public function __call($name, $arguments)
    {
        if (preg_match('/^is/', $name) === 0) {
            throw new BadMethodCallException('Match method of enum must be start from "is".');
        }

        $reflection = new ReflectionClass(static::class);

        $name      = preg_replace('/^is/', '', $name);
        $constName = snakeUpperCase($name);
        $constList = $reflection->getConstants();

        if (!$reflection->hasConstant($constName)) {
            throw new BadMethodCallException('Enum factory method must be has same const keyword.');
        }

        return $constList[$constName] === $this->status;
    }
}
