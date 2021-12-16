<?php

namespace Lee\Live\Application\Search;

use Lee\Live\Application\Search\SearchQuery\SearchQuery;

interface SearchQueryService
{
    /**
     * @var SearchViewModel[]
     */
    public function search(SearchQuery $searchQuery): array;
}
