<?php

declare(strict_types=1);

namespace Lee\Live\Infrastructure\DataResource\LiveSearchQueryService;

use Carbon\Carbon;
use Lee\Live\Application\Search\SearchQuery\KeywordType;
use Lee\Live\Application\Search\SearchQuery\SearchQuery;
use Lee\Live\Application\Search\SearchQuery\SearchType;
use Lee\Live\Application\Search\SearchQueryService;
use Lee\Live\Application\Search\SearchViewModel;
use Lee\Live\Shared\Date;
use Lee\Live\Domain\Model\Live\LiveHouse\Prefecture;
use Lee\Live\Domain\Model\Live\LiveId;
use Lee\Live\Domain\Model\Live\Name;

final class InMemoryLiveSearchQueryService implements SearchQueryService
{
    private array $dataResource = [];

    /**
     * @param  SearchQuery       $searchQuery
     * @return SearchViewModel[]
     */
    public function search(SearchQuery $searchQuery): array
    {
        if ($searchQuery->isAllSearchQuery()) {
            return array_map(fn (array $data) => $this->makeSearchViewModel($data), $this->dataResource);
        }

        // SQL生成
        foreach ($searchQuery->getQuery() as $query) {
            $column        = $this->translateToColumn($query->getKeywordType());
            $searchMethod  = $this->translateToSearchMethod($query->getSearchType());
            $expectedValue = $query->getValue();

            $sql[] = ['column' => $column, 'searchMethod' => $searchMethod, 'expectedValue' => $expectedValue];
        }

        // 検索
        foreach ($this->dataResource as $data) {
            $matchedColumn = array_filter($sql, function ($aSql) use ($data) {
                $methodName = $aSql['searchMethod'];

                return $this->$methodName([$data[$aSql['column']], $aSql['expectedValue']]);
            });

            if (count($matchedColumn) === count($sql)) {
                $result[] = $data;
            }
        }

        if (!isset($result) || count($result) === 0) {
            return [];
        }

        // ViewModelに変換
        foreach ($result as $aResult) {
            $viewModels[] = $this->makeSearchViewModel($aResult);
        }

        return $viewModels;
    }

    /*
    |--------------------------------------------------------------------------
    | SearchViewModelの生成
    |--------------------------------------------------------------------------
    |
    */
    private function makeSearchViewModel($data): SearchViewModel
    {
        return new SearchViewModel(
            new LiveId($data['id']),
            new Name($data['live_house_name']),
            isset($data['ticket_sale_start_date']) ? Date::factoryFromString($data['ticket_sale_start_date']) : null,
            isset($data['live_start_date']) ? Date::factoryFromString($data['live_start_date']) : null,
            isset($data['actors']) ? array_map(fn ($actor) => new Name($actor), $data['actors']) : null,
            isset($data['prefecture']) ? new Prefecture($data['prefecture']) : null,
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SQL要素への変換処理
    |--------------------------------------------------------------------------
    */

    /**
     * カラム名への変換処理
     *
     * @param  KeywordType $keywordType
     * @return string
     */
    private function translateToColumn(KeywordType $keywordType): string
    {
        if ($keywordType->isAll()) {
            return 'all';
        }
        if ($keywordType->isArtistName()) {
            return 'actors';
        }
        if ($keywordType->isLiveHouseName()) {
            return 'live_house_name';
        }
        if ($keywordType->isLiveStartDate()) {
            return 'live_start_date';
        }
        if ($keywordType->isPrefecture()) {
            return 'prefecture';
        }
    }

    /**
     * 検索メソッド名の変換処理
     *
     * @param  SearchType $searchType
     * @return string
     */
    private function translateToSearchMethod(SearchType $searchType): string
    {
        if ($searchType->isAllSearch()) {
            return 'isNotFilter';
        }
        if ($searchType->isEqualSearch()) {
            return 'isEqual';
        }
        if ($searchType->isPartialSearch()) {
            return 'isLike';
        }
        if ($searchType->isMoreThanSearch()) {
            return 'isMoreOverThan';
        }
    }

    /*
    |--------------------------------------------------------------------------
    |　検索メソッド
    |--------------------------------------------------------------------------
    */

    private function isNotFilter(array $data): bool
    {
        return true;
    }

    private function isEqual(array $data): bool
    {
        if (is_array($data[0])) {
            return in_array($data[1], $data[0]);
        }

        return $data[0] === $data[1];
    }

    private function isLike(array $data): bool
    {
        if (is_array($data[0])) {
            $expectedValue = $data[1];
            $result        = array_filter($data[0], function ($actualData) use ($expectedValue) {
                return $this->isLike([$actualData, $expectedValue]);
            });

            return count($result) > 0;
        }

        $pattern = '/' . $data[1] . '/';

        return preg_match($pattern, $data[0]) === 1;
    }

    private function isMoreOverThan(array $data): bool
    {
        $actual   = Carbon::createFromTimeString($data[0]);
        $expected = Carbon::createFromTimeString($data[1]);

        return $actual->gte($expected);
    }

    /*
    |--------------------------------------------------------------------------
    | インメモリへのデータCRUD操作
    |--------------------------------------------------------------------------
    |
    */

    public function insert(array $data): self
    {
        $this->dataResource[] = $data;

        return $this;
    }

    public function getResult(): array
    {
        return $this->dataResource;
    }
}
