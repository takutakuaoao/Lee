<?php

declare(strict_types=1);

namespace Lee\Live\Infrastructure\DataResource\ArtistRepository;

use Lee\Live\Domain\Model\Artist\Artist;
use Lee\Live\Domain\Model\Artist\ArtistDto;
use Lee\Live\Domain\Model\Artist\ArtistFactory;
use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Artist\ArtistRepository;
use Lee\Live\Domain\Model\Live\Name;

final class NonConnectionDataResourceArtistRepository implements ArtistRepository
{
    public ArtistId $returnArtistId;
    public bool $returnBool = true;
    public ?Artist $returnArtist;
    public ?array $returnArtists;

    /** @var ArtistDto[] */
    public array $storeArtist = [];

    public function __construct()
    {
        $this->returnArtistId = new ArtistId('test');
        $this->returnArtist   = (new ArtistFactory)->createArtist(
            new ArtistId('test'),
            new Name('artist name'),
        );
        $this->returnArtists = [$this->returnArtist];
    }

    public function findIdByName(string $name): ?ArtistId
    {
        return $this->returnArtistId;
    }

    public function issueId(): ArtistId
    {
        return $this->returnArtistId;
    }

    public function exists(ArtistId $artistId): bool
    {
        return $this->returnBool;
    }

    public function findById(ArtistId $artistId): ?Artist
    {
        return $this->returnArtist;
    }

    /**
     * @param  ArtistId[]    $artistIds
     * @return Artist[]|null
     */
    public function findArtistsByIds(array $artistIds): ?array
    {
        return $this->returnArtists;
    }

    public function store(ArtistDto $artistDto): void
    {
        $this->storeArtist[] = $artistDto;
    }
}
