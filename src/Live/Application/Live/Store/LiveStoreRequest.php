<?php

declare(strict_types=1);

namespace Lee\Live\Application\Live\Store;

final class LiveStoreRequest
{
    public function __construct(
        private string $liveName,
        private string $liveDate,
        private string $liveHouseName,
        private string $prefecture,
        private string $address,
        private array $actorIds,
    ) {
    }

    public function getLiveName(): string
    {
        return $this->liveName;
    }

    public function getLiveDate(): string
    {
        return $this->liveDate;
    }

    public function getLiveHouseName(): string
    {
        return $this->liveHouseName;
    }

    public function getPrefecture(): string
    {
        return $this->prefecture;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getActorIds(): array
    {
        return $this->actorIds;
    }
}
