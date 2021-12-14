<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Live;

final class LiveDto
{
    public function __construct(
        private string $liveId,
        private string $liveName,
        private string $startDate,
        private string $liveHouseName,
        private string $prefecture,
        private string $address,
        private array $actorIds,
    ) {
    }

    public function getLiveId(): string
    {
        return $this->liveId;
    }

    public function getLiveName(): string
    {
        return $this->liveName;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
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
