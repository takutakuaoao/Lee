<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Infrastructure\DataResource\LiveSearchQueryService;

use Lee\Live\Application\Search\SearchQuery\KeywordType;
use Lee\Live\Application\Search\SearchQuery\Query;
use Lee\Live\Application\Search\SearchQuery\SearchQuery;
use Lee\Live\Application\Search\SearchQuery\SearchType;
use Lee\Live\Infrastructure\DataResource\LiveSearchQueryService\InMemoryLiveSearchQueryService;
use PHPUnit\Framework\TestCase;

class InMemoryLiveSearchQueryServiceTest extends TestCase
{
    public function test_insert(): void
    {
        $queryService = new InMemoryLiveSearchQueryService();
        $result       = $queryService->insert(['id' => '1', 'live_house_name' => 'サウンドクルー'])->getResult();

        $this->assertEquals('サウンドクルー', $result[0]['live_house_name']);
    }

    public function test_search_one_hit(): void
    {
        $queryService = new InMemoryLiveSearchQueryService();
        $queryService->insert(['id' => '1', 'live_house_name' => 'サウンドクルー'])
            ->insert(['id' => '2', 'live_house_name' => 'テスト']);

        $searchQuery = new SearchQuery([
            new Query(KeywordType::liveHouseName(), SearchType::equalSearch(), 'サウンドクルー'),
        ]);
        $result = $queryService->search($searchQuery);

        $this->assertEquals(1, count($result));
        $this->assertEquals(1, $result[0]->jsonSerialize()['id']);
    }

    public function test_partial_search_one_hit(): void
    {
        $queryService = new InMemoryLiveSearchQueryService();
        $queryService->insert(['id' => '1', 'live_house_name' => 'サウンドクルー'])
            ->insert(['id' => '2', 'live_house_name' => 'テスト']);

        $searchQuery = new SearchQuery([
            new Query(KeywordType::liveHouseName(), SearchType::partialSearch(), 'テス'),
        ]);
        $result = $queryService->search($searchQuery);

        $this->assertEquals(1, count($result));
        $this->assertEquals(2, $result[0]->jsonSerialize()['id']);
    }

    public function test_search_actors(): void
    {
        $queryService = new InMemoryLiveSearchQueryService();
        $queryService->insert(['id' => '1', 'live_house_name' => 'サウンドクルー', 'actors' => ['artist3', 'artist1']])
            ->insert(['id' => '2', 'live_house_name' => 'テスト', 'actors' => ['artist2']]);

        $searchQuery = new SearchQuery([
            new Query(KeywordType::artistName(), SearchType::equalSearch(), 'artist1'),
        ]);
        $result = $queryService->search($searchQuery);

        $this->assertEquals(1, count($result));
        $this->assertEquals(1, $result[0]->jsonSerialize()['id']);
    }

    public function test_particle_search_actors(): void
    {
        $queryService = new InMemoryLiveSearchQueryService();
        $queryService->insert(['id' => '1', 'live_house_name' => 'サウンドクルー', 'actors' => ['artist3', 'artist1']])
            ->insert(['id' => '2', 'live_house_name' => 'テスト', 'actors' => ['artist2']]);

        $searchQuery = new SearchQuery([
            new Query(KeywordType::artistName(), SearchType::partialSearch(), '3'),
        ]);
        $result = $queryService->search($searchQuery);

        $this->assertEquals(1, count($result));
        $this->assertEquals(1, $result[0]->jsonSerialize()['id']);
    }

    public function test_multiple_search(): void
    {
        $queryService = new InMemoryLiveSearchQueryService();
        $queryService->insert(['id' => '1', 'live_house_name' => 'サウンドクルー', 'actors' => ['artist3', 'artist1']])
            ->insert(['id' => '2', 'live_house_name' => 'テスト', 'actors' => ['artist2']]);

        $searchQuery = new SearchQuery([
            new Query(KeywordType::artistName(), SearchType::partialSearch(), '3'),
            new Query(KeywordType::liveHouseName(), SearchType::partialSearch(), 'サウン'),
        ]);
        $result = $queryService->search($searchQuery);

        $this->assertEquals(1, count($result));
        $this->assertEquals(1, $result[0]->jsonSerialize()['id']);
    }

    public function test_has_multiple_result(): void
    {
        $queryService = new InMemoryLiveSearchQueryService();
        $queryService->insert(['id' => '1', 'live_house_name' => 'サウンドクルー', 'actors' => ['artist3', 'artist1']])
            ->insert(['id' => '2', 'live_house_name' => 'テスト', 'actors' => ['artist2']]);

        $searchQuery = new SearchQuery([
            new Query(KeywordType::artistName(), SearchType::partialSearch(), 'rtis'),
        ]);
        $result = $queryService->search($searchQuery);

        $this->assertEquals(2, count($result));
        $this->assertEquals(1, $result[0]->jsonSerialize()['id']);
        $this->assertEquals(2, $result[1]->jsonSerialize()['id']);
    }

    public function test_more_than_search(): void
    {
        $queryService = new InMemoryLiveSearchQueryService();
        $queryService->insert(['id' => '1', 'live_house_name' => 'テスト', 'live_start_date' => '2021/02/01 00:00:00'])
            ->insert(['id' => '2', 'live_house_name' => 'テスト', 'live_start_date' => '2021/01/01 23:59:58']);

        $searchQuery = new SearchQuery([
            new Query(KeywordType::liveStartDate(), SearchType::moreThanSearch(), '2021/01/01 23:59:59'),
        ]);
        $result = $queryService->search($searchQuery);

        $this->assertEquals(1, count($result));
        $this->assertEquals(1, $result[0]->jsonSerialize()['id']);
    }

    public function test_search_prefecture(): void
    {
        $queryService = new InMemoryLiveSearchQueryService();
        $queryService->insert(['id' => '1', 'live_house_name' => 'テスト', 'prefecture' => '北海道'])
            ->insert(['id' => '2', 'live_house_name' => 'テスト', 'prefecture' => '北海道']);

        $searchQuery = new SearchQuery([
            new Query(KeywordType::prefecture(), SearchType::equalSearch(), '北海道'),
        ]);
        $result = $queryService->search($searchQuery);

        $this->assertEquals(2, count($result));
        $this->assertEquals(1, $result[0]->jsonSerialize()['id']);
        $this->assertEquals(2, $result[1]->jsonSerialize()['id']);
    }

    public function test_no_search_result(): void
    {
        $queryService = new InMemoryLiveSearchQueryService();
        $queryService->insert(['id' => '1', 'live_house_name' => 'テスト', 'live_start_date' => '2021/02/01 00:00:00']);

        $searchQuery = new SearchQuery([
            new Query(KeywordType::liveStartDate(), SearchType::moreThanSearch(), '2021/02/01 00:00:01'),
        ]);
        $result = $queryService->search($searchQuery);

        $this->assertEquals(0, count($result));
    }
}
