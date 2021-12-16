<?php

namespace Tests\Unit\Live\Application\Search\SearchQuery\Query;

use Lee\Live\Application\Search\SearchQuery\SearchType;
use PHPUnit\Framework\TestCase;

class SearchTypeTest extends TestCase
{
    public function test_all_search(): void
    {
        $type = SearchType::allSearch();

        $this->assertTrue($type->isAllSearch());
    }

    public function test_equal(): void
    {
        $type = SearchType::equalSearch();

        $this->assertTrue($type->equal(SearchType::equalSearch()));
    }

    public function test_create_equal_search_type(): void
    {
        $type = SearchType::equalSearch();

        $this->assertTrue($type->isEqualSearch());
    }

    public function test_create_partial_search_type(): void
    {
        $type = SearchType::partialSearch();

        $this->assertTrue($type->isPartialSearch());
    }

    public function test_create_more_than_search_type(): void
    {
        $type = SearchType::moreThanSearch();

        $this->assertTrue($type->isMoreThanSearch());
    }
}
