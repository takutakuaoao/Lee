<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Domain\Model\Live;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Artist\ArtistRepository;
use Lee\Live\Domain\Model\Live\Live;
use Lee\Live\Domain\Model\Live\LiveHouse\Address;
use Lee\Live\Domain\Model\Live\LiveHouse\LiveHouse;
use Lee\Live\Domain\Model\Live\LiveHouse\Location;
use Lee\Live\Domain\Model\Live\LiveHouse\Prefecture;
use Lee\Live\Domain\Model\Live\LiveId;
use Lee\Live\Domain\Model\Live\LiveName;
use Lee\Live\Infrastructure\DataResource\ArtistRepository\NonConnectionDataResourceArtistRepository;
use Lee\Live\Shared\Date;
use Lee\Live\Shared\Exception\NotFoundException;
use Lee\Live\Shared\Name;
use Tests\TestCase;

class LiveTest extends TestCase
{
    use RefreshDatabase;

    private NonConnectionDataResourceArtistRepository $mockArtistRepository;

    public function setUp(): void
    {
        $this->mockArtistRepository = new NonConnectionDataResourceArtistRepository;
    }

    public function test_to_string(): void
    {
        $live = $this->makeLive(artistRepository: $this->mockArtistRepository);

        $this->assertEquals("[Live Instance Id] 1", $live);
    }

    public function test_throw_exception_when_not_found_artist_id_from_data_resource(): void
    {
        $this->expectException(NotFoundException::class);

        $this->mockArtistRepository->returnBool = false;
        $this->makeLive(artistRepository: $this->mockArtistRepository);
    }

    private function makeLive(
        string $id = '1',
        array $actors = ['1'],
        string $liveName = 'test',
        array $liveHouse = ['live house', ['北海道', '住所']],
        string $liveDate = '2021/01/01 00:00',
        ArtistRepository $artistRepository,
    ): Live {
        $id        = new LiveId($id);
        $liveName  = new LiveName($liveName);
        $actors    = array_map(fn ($actorId) => new ArtistId($actorId), $actors);
        $liveHouse = new LiveHouse(new Name($liveHouse[0]), new Location(new Prefecture($liveHouse[1][0]), new Address($liveHouse[1][1])));
        $liveDate  = Date::factoryFromString($liveDate);

        return new Live($id, $liveName, $liveHouse, $liveDate, $actors, $artistRepository);
    }
}
