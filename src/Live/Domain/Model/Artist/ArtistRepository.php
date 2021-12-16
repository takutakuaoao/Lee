<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Artist;

interface ArtistRepository
{
    public function findIdByName(string $name): ?ArtistId;
    public function issueId(): ArtistId;
    public function exists(ArtistId $artistId): bool;
    public function findById(ArtistId $artistId): ?Artist;

    /**
     * @param ArtistId[] $artistIds
     * @return Artist[]|null
     */
    public function findArtistsByIds(array $artistIds): ?array;

    public function store(ArtistDto $artistDto): void;
}
