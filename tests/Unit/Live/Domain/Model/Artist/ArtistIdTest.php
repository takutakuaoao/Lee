<?php

namespace Tests\Unit\Live\Domain\Model\Artist;

use InvalidArgumentException;
use Lee\Live\Domain\Model\Artist\ArtistId;
use PHPUnit\Framework\TestCase;

class ArtistIdTest extends TestCase
{
    public function test_is_contain(): void
    {
        $artistId = new ArtistId('artist-1');

        $this->assertTrue($artistId->isContain([new ArtistId('artist-1'), new ArtistId('artist-2')]));
        $this->assertFalse($artistId->isContain([new ArtistId('artist-3')]));
    }

    public function test_throw_exception_when_argument_is_not_artist_id_class(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new ArtistId('artist-1'))->isContain(['artist-id']);
    }
}
