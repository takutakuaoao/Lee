<?php

namespace Tests\Unit\Live\Domain\Model\User;

use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\User\FavoriteArtists;
use PHPUnit\Framework\TestCase;

class FavoriteArtistsTest extends TestCase
{
    public function test_select_favorite_artist(): void
    {
        $favoriteArtists = (new FavoriteArtists([new ArtistId('artist-1')]))->selectFavoriteArtist([new ArtistId('artist-1')]);

        $this->assertEquals(['artist-1'], $favoriteArtists->toArray());
    }

    public function test_add(): void
    {
        $favoriteArtists = (new FavoriteArtists([]))->add(new ArtistId('artist-1'));

        $this->assertEquals(['artist-1'], $favoriteArtists->toArray());
    }
}
