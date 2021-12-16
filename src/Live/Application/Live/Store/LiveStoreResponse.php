<?php

declare(strict_types=1);

namespace Lee\Live\Application\Live\Store;

final class LiveStoreResponse
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
