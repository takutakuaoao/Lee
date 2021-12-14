<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Infrastructure\DataResource\ArtistRepository;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Lee\Live\Domain\Model\Artist\Artist;
use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Live\Name;
use Lee\Live\Infrastructure\DataResource\ArtistRepository\QueryBuilderArtistRepository;
use Tests\TestCase;

class QueryBuilderArtistRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private QueryBuilderArtistRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new QueryBuilderArtistRepository;
    }

    public function test_find_id_by_name(): void
    {
        DB::table('artists')->insert(['id' => 'test', 'name' => 'artist-name']);
        $id = $this->repository->findIdByName('artist-name');

        $this->assertTrue($id->equal(new ArtistId('test')));
    }

    public function test_not_found_id_by_name(): void
    {
        $id = $this->repository->findIdByName('artist-name');

        $this->assertNull($id);
    }

    public function test_find_by_id(): void
    {
        DB::table('artists')->insert(['id' => 'test', 'name' => 'artist-name']);
        $artist = $this->repository->findById(new ArtistId('test'));

        $this->assertTrue($artist->sameAs(new Artist(new ArtistId('test'), new Name('name'))));
    }

    public function test_issue_id(): void
    {
        DB::table('artists')->insert(['id' => 'test', 'name' => 'artist-name']);
        $id = $this->repository->issueId();

        $this->assertTrue($id instanceof ArtistId);
        $this->assertFalse($id->equal(new ArtistId('test')));
    }

    public function test_exists(): void
    {
        DB::table('artists')->insert(['id' => 'test', 'name' => 'artist-name']);

        $this->assertTrue($this->repository->exists(new ArtistId('test')));
    }
}
