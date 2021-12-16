<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Infrastructure\DataResource\LiveRepository;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Lee\Live\Domain\Model\Live\LiveDto;
use Lee\Live\Domain\Model\Live\LiveId;
use Lee\Live\Infrastructure\DataResource\LiveRepository\QueryBuilderLiveRepository;
use Tests\TestCase;

class QueryBuilderLiveRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private QueryBuilderLiveRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new QueryBuilderLiveRepository();
    }

    public function test_store(): void
    {
        $liveDto = new LiveDto(
            'liveId',
            'ライブ名',
            '2021-12-31 00:00:00',
            'ライブハウス名',
            '東京都',
            '住所',
            ['artistId1', 'artistId2'],
        );

        $this->repository->store($liveDto);

        $this->assertTrue(DB::table('lives')->where(['id' => 'liveId'])->exists());
        $this->assertTrue(DB::table('live_houses')->where(['name' => 'ライブハウス名', 'prefecture' => '東京都', 'address' => '住所'])->exists());
        $this->assertTrue(DB::table('live_actors')->where(['live_id' => 'liveId', 'artist_id' => 'artistId1'])->exists());
        $this->assertTrue(DB::table('live_actors')->where(['live_id' => 'liveId', 'artist_id' => 'artistId2'])->exists());
    }

    public function test_exists_by_id(): void
    {
        DB::table('lives')->insert(['id' => $searchId = 'test', 'name' => 'name', 'start_date' => '2021/01/01 00:00:00', 'live_house_id' => 'xxx']);

        $this->assertTrue($this->repository->existsById(new LiveId($searchId)));
    }

    public function test_not_exists_by_id(): void
    {
        $this->assertFalse($this->repository->existsById(new LiveId('not-exists-id')));
    }
}
