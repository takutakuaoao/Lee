<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Artist;

use InvalidArgumentException;
use Lee\Live\Shared\ValueObject;

final class ArtistId implements ValueObject
{
    private string $value;

    public function __construct(?string $value = null)
    {
        $this->value = $value ?? uniqid('', true);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param  ArtistId[] $artistIds
     * @return bool
     */
    public function isContain(array $artistIds): bool
    {
        if(array_filter($artistIds, fn($artistId) => !($artistId instanceof ArtistId)) !== []) {
            throw new InvalidArgumentException('Argument of isContain method must be ArtistId class.');
        }

        $result = array_filter($artistIds, fn(ArtistId $artistId) => $artistId->equal($this));

        return count($result) > 0;
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
