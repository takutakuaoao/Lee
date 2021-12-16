<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Application\Search\SearchQuery;

use Lee\Live\Application\Search\SearchQuery\KeywordType;
use PHPUnit\Framework\TestCase;

class KeywordTypeTest extends TestCase
{
    public function test_is_all(): void
    {
        $this->assertTrue(KeywordType::all()->isAll());
    }

    public function test_is_artist_name(): void
    {
        $this->assertTrue(KeywordType::artistName()->isArtistName());
    }

    public function test_is_live_house_name(): void
    {
        $this->assertTrue(KeywordType::liveHouseName()->isLiveHouseName());
    }

    public function test_is_live_start_date(): void
    {
        $this->assertTrue(KeywordType::liveStartDate()->isLiveStartDate());
    }

    public function test_is_prefecture(): void
    {
        $this->assertTrue(KeywordType::prefecture()->isPrefecture());
    }
}
