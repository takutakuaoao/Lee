<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Live\LiveHouse;

use Lee\Live\Shared\Name;
use Lee\Live\Shared\ValueObject;

class LiveHouse implements ValueObject
{
    public function __construct(
        private Name $name,
        private Location $location
    ) {
    }

    public function getLiveHouseName(): Name
    {
        return $this->name;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function toPrimitives(): array
    {
        $location = $this->location->toPrimitives();

        return ['name' => (string)$this->name] + $location;
    }

    public function equal(ValueObject $value): bool
    {
        return get_class($this) && get_class($value) &&
            $this->name->equal($value->name) &&
            $this->location->equal($value->location);
    }

    public function __toString()
    {
        return "ライブハウス名: {$this->name}, 所在地: {$this->location}";
    }
}
