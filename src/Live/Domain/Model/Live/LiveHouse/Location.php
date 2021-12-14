<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Live\LiveHouse;

use Lee\Live\Shared\ValueObject;

final class Location implements ValueObject
{
    /** @var Prefecture */
    private $prefecture;

    /** @var Address */
    private $address;

    public function __construct(Prefecture $prefecture, Address $address)
    {
        $this->prefecture = $prefecture;
        $this->address    = $address;
    }

    public function toPrimitives(): array
    {
        return [
            'prefecture' => (string)$this->prefecture,
            'address'    => (string)$this->address,
        ];
    }

    public function equal(ValueObject $value): bool
    {
        return get_class($this) === get_class($value) && $this->prefecture->equal($value->prefecture) && $this->address->equal($value->address);
    }

    public function __toString()
    {
        return $this->prefecture . ' ' . $this->address;
    }
}
