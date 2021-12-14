<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Artist;

use Lee\Live\Domain\Model\Live\Name;

class Artist
{
    public function __construct(
        private ArtistId $id,
        private Name $name,
    ) {
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function sameAs(Artist $artist): bool
    {
        return $this->id->equal($artist->id);
    }

    public function __toString(): string
    {
        return (string)$this->name;
    }
}
