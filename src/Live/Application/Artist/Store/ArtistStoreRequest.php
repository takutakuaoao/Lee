<?php

declare(strict_types=1);

namespace Lee\Live\Application\Artist\Store;

final class ArtistStoreRequest
{
    public function __construct(
        private string $artistName,
    ) {
    }

    public function getArtistName(): string
    {
        return $this->artistName;
    }
}
