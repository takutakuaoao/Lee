<?php

declare(strict_types=1);


namespace Lee\Live\Application\Artist\Store;

final class ArtistStoreResponse
{
    public function __construct(
        private bool $result,
    ) {
    }

    public function getResult(): bool
    {
        return $this->result;
    }
}
