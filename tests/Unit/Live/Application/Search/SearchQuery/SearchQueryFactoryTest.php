<?php

namespace Tests\Unit\Live\Application\Search\SearchQuery;

use Lee\Live\Application\Search\SearchQuery\SearchQueryFactory;
use PHPUnit\Framework\TestCase;

class SearchQueryFactoryTest extends TestCase
{
    public function test_factory_all(): void
    {
        $factory = new SearchQueryFactory([]);
        $queries = $factory->factory()->getQuery();

        $this->assertTrue($queries[0]->getKeywordType()->isAll());
        $this->assertTrue($queries[0]->getSearchType()->isAllSearch());
        $this->assertEquals('', $queries[0]->getValue());
    }

    public function test_factory_live_house_name(): void
    {
        $factory = new SearchQueryFactory([['live_house_name' => 'test']]);
        $queries = $factory->factory()->getQuery();

        $this->assertTrue($queries[0]->getKeywordType()->isLiveHouseName());
        $this->assertTrue($queries[0]->getSearchType()->isPartialSearch());
        $this->assertEquals('test', $queries[0]->getValue());
    }

    public function test_factory_artist_name(): void
    {
        $factory = new SearchQueryFactory([['artist_name' => 'test']]);
        $queries = $factory->factory()->getQuery();

        $this->assertTrue($queries[0]->getKeywordType()->isArtistName());
        $this->assertTrue($queries[0]->getSearchType()->isPartialSearch());
        $this->assertEquals('test', $queries[0]->getValue());
    }

    public function test_factory_prefecture(): void
    {
        $factory = new SearchQueryFactory([['prefecture' => '北海道']]);
        $queries = $factory->factory()->getQuery();

        $this->assertTrue($queries[0]->getKeywordType()->isPrefecture());
        $this->assertTrue($queries[0]->getSearchType()->isEqualSearch());
        $this->assertEquals('北海道', $queries[0]->getValue());
    }
}
