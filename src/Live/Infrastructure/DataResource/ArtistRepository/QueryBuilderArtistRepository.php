<?php

declare(strict_types=1);

namespace Lee\Live\Infrastructure\DataResource\ArtistRepository;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Lee\Live\Domain\Model\Artist\Artist;
use Lee\Live\Domain\Model\Artist\ArtistDto;
use Lee\Live\Domain\Model\Artist\ArtistFactory;
use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Artist\ArtistRepository;
use Lee\Live\Domain\Model\Live\Name;

final class QueryBuilderArtistRepository implements ArtistRepository
{
    private Builder $builder;

    public function __construct()
    {
        $this->builder = DB::table('artists');
    }

    public function findIdByName(string $name): ?ArtistId
    {
        $query = $this->builder->where('name', $name);

        if (!$query->exists()) {
            return null;
        }

        return new ArtistId($query->first()->id);
    }

    public function findById(ArtistId $artistId): ?Artist
    {
        if (!$this->exists($artistId)) {
            return null;
        }

        $artist = $this->builder->where('id', '=', $artistId)->first();

        return (new ArtistFactory)->createArtist(
            new ArtistId($artist->id),
            new Name($artist->name),
        );
    }

    public function findArtistsByIds(array $artistIds): ?array
    {
        $artists = array_map(fn (ArtistId $artistId) => $this->findById($artistId), $artistIds);
        $artists = array_filter($artists, fn ($artist) => !is_null($artist));

        return array_values($artists);
    }

    public function issueId(): ArtistId
    {
        return new ArtistId(uniqid('', true));
    }

    public function exists(ArtistId $id): bool
    {
        $query = $this->builder->where('id', (string)$id);

        return $query->exists();
    }

    public function store(ArtistDto $artistDto): void
    {
        $this->builder->insert([
            'id'   => $artistDto->getId(),
            'name' => $artistDto->getName(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
