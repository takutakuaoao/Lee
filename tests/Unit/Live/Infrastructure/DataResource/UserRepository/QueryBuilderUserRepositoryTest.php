<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Infrastructure\DataResource\UserRepository;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Infrastructure\DataResource\UserRepository\QueryBuilderUserRepository;
use Tests\TestCase;

class QueryBuilderUserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private QueryBuilderUserRepository $queryBuilderUserRepository;

    public function setUp(): void
    {
        parent::setUp();

        DB::table('users')->insert([
            [
                'id'       => 'user1',
                'email'    => 'test@test.com',
                'password' => 'password',
                'type'     => 1,
            ],
            [
                'id'       => 'user2',
                'email'    => 'test1@test.com',
                'password' => 'password',
                'type'     => 1,
            ],
            [
                'id'       => 'user3',
                'email'    => 'test2@test.com',
                'password' => 'password',
                'type'     => 1,
            ],
        ]);
        DB::table('favorite_artists')->insert([
            ['user_id' => 'user1', 'artist_id' => 'artist1', ],
            ['user_id' => 'user1', 'artist_id' => 'artist2', ],
            ['user_id' => 'user2', 'artist_id' => 'artist1', ],
            ['user_id' => 'user3', 'artist_id' => 'artist3', ],
        ]);

        $this->queryBuilderUserRepository = new QueryBuilderUserRepository;
    }

    public function test_find_by_artist_id(): void
    {
        $users = $this->queryBuilderUserRepository->findByArtistId(new ArtistId('artist1'));

        $this->assertEquals('user1', $users[0]->toPrimitive()['id']);
    }

    public function test_find_by_artist_id_when_multiple_artist_id_art_connection_to_user(): void
    {
        $users = $this->queryBuilderUserRepository->findByArtistId(new ArtistId('artist2'));

        $this->assertEquals('user1', $users[0]->toPrimitive()['id']);
        $this->assertEquals('artist1', $users[0]->toPrimitive()['artistIds'][0]);
        $this->assertEquals('artist2', $users[0]->toPrimitive()['artistIds'][1]);
        $this->assertEquals(1, count($users));
    }

    public function test_not_found_by_artist_id(): void
    {
        $users = $this->queryBuilderUserRepository->findByArtistId(new ArtistId('not-exists-artist-id'));

        $this->assertNull($users);
    }

    public function test_multiple_user_find_by_artist_id(): void
    {
        $users = $this->queryBuilderUserRepository->findByArtistId(new ArtistId('artist1'));
        $this->assertEquals(2, count($users));
    }

    public function test_find_by_multiple_artist_id(): void
    {
        $users = $this->queryBuilderUserRepository->findByMultipleArtistId([new ArtistId('artist1'), new ArtistId('artist2'), new ArtistId('artist3')]);

        $this->assertEquals(3, count($users));
        $this->assertEquals('user1', $users[0]->toPrimitive()['id']);
        $this->assertEquals('user2', $users[1]->toPrimitive()['id']);
        $this->assertEquals('user3', $users[2]->toPrimitive()['id']);
    }
}
