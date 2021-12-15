<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User;

use Lee\Live\Domain\Model\Artist\ArtistId;

final class FavoriteArtists
{
    public function __construct(private array $artistIds = [])
    {
    }

    /**
     * @param  ArtistId[] $artistIds
     * @return self|null
     */
    public function selectFavoriteArtist(array $artistIds): ?self
    {
        if ($this->artistIds === []) {
            return null;
        }

        $matchedArtistId = array_filter($artistIds, function (ArtistId $artistId) {
            return $artistId->isContain($this->artistIds);
        });

        if ($matchedArtistId === []) {
            return null;
        }

        return new self($matchedArtistId);
    }

    public function add(ArtistId $artistId): self
    {
        $artistIds = $this->artistIds;

        return new FavoriteArtists(array_merge($artistIds, [$artistId]));
    }

    public function isAllUnique(): bool
    {
        $ids = array_map(fn (ArtistId $artistId) => (string)$artistId, $this->artistIds);

        return $ids === array_unique($ids);
    }

    public function count(): int
    {
        return count($this->artistIds);
    }

    public function toArray(): array
    {
        return array_map(fn (ArtistId $artistId) => (string)$artistId, $this->artistIds);
    }

    /**
     * @return ArtistId[]
     */
    public function getArtistIds(): array
    {
        return $this->artistIds;
    }
}
