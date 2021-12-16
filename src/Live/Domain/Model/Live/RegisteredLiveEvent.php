<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Live;

use Illuminate\Foundation\Events\Dispatchable;
use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Shared\Exception\EventException;

final class RegisteredLiveEvent
{
    use Dispatchable;

    public function __construct(
        private array $artistIds,
        private string $liveName,
        private string $liveDate,
        private string $liveHouseName,
        private string $liveHouseLocation,
    ) {
        foreach($artistIds as $artistId) {
            if (! ($artistId instanceof ArtistId)) {
                throw new EventException();
            }
        }
    }

    /**
     * @return ArtistId[]
     */
    public function getArtistIds(): array
    {
        return $this->artistIds;
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

    public function getLiveHouseLocation(): string
    {
        return $this->liveHouseLocation;
    }
}
