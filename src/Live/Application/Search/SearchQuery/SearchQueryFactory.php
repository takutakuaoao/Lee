<?php

declare(strict_types=1);

namespace Lee\Live\Application\Search\SearchQuery;

final class SearchQueryFactory
{
    private const LIVE_HOUSE_NAME = 'live_house_name';
    private const ARTIST_NAME     = 'artist_name';
    private const PREFECTURE      = 'prefecture';

    public function __construct(
        private array $request
    ) {
    }

    public function factory(): SearchQuery
    {
        if ($this->request === [] || $this->request[0] === []) {
            return new SearchQuery([new Query(KeywordType::all(), SearchType::allSearch(), ''), ]);
        }

        $queries = array_map(function ($requestItem) {
            return $this->factoryQuery(key($requestItem), $requestItem[key($requestItem)]);
        }, $this->request);

        return new SearchQuery($queries);
    }

    private function factoryQuery(string $searchItemName, string $searchValue): Query
    {
        if ($searchItemName === static::LIVE_HOUSE_NAME) {
            return new Query(KeywordType::liveHouseName(), SearchType::partialSearch(), $searchValue);
        }

        if ($searchItemName === static::ARTIST_NAME) {
            return new Query(KeywordType::artistName(), SearchType::partialSearch(), $searchValue);
        }

        if ($searchItemName === static::PREFECTURE) {
            return new Query(KeywordType::prefecture(), SearchType::equalSearch(), $searchValue);
        }
    }
}
