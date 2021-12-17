<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User;

use Lee\Live\Domain\Model\Artist\ArtistId;

interface UserRepository
{
    /**
     * @param  ArtistId    $artistId
     * @return User[]|null
     */
    public function findByArtistId(ArtistId $artistId): ?array;

    /**
     * @param  ArtistId[]  $artistIds
     * @return User[]|null
     */
    public function findByMultipleArtistId(array $artistIds): ?array;

    public function existsByEmail(Email $email): bool;
}
