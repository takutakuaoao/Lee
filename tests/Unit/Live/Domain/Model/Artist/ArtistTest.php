<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Domain\Model\Artist;

use Lee\Live\Domain\Model\Artist\Artist;
use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Live\Name;
use PHPUnit\Framework\TestCase;

class ArtistTest extends TestCase
{
    public function test_to_string(): void
    {
        $artistInfo = new Artist(new ArtistId('1'), new Name('artist name'));

        $this->assertEquals('artist name', $artistInfo);
    }
}
