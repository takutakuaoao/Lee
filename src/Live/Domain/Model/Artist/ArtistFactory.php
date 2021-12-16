<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Artist;

use Lee\Live\Domain\Model\Live\Name;

final class ArtistFactory
{
    public function createArtist(ArtistId $artistId, Name $name): Artist
    {
        return new Artist($artistId, $name);
    }

    public function createNewArtist(Name $name): Artist
    {
        return new Artist(ArtistId::createNewId(), $name);
    }
}
