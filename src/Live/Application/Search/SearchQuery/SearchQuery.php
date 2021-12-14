<?php

declare(strict_types=1);

namespace Lee\Live\Application\Search\SearchQuery;

use Lee\Live\Shared\ValueObject;

final class SearchQuery implements ValueObject
{
    /**
     * @param Query[] $queries
     */
    public function __construct(private array $queries)
    {
        foreach ($queries as $query) {
            assert($query instanceof Query, 'array be all Query instance.');
        }
    }

    public function isAllSearchQuery(): bool
    {
        return count($this->queries) === 1 &&
            $this->queries[0]->getSearchType()->isAllSearch() &&
            $this->queries[0]->getKeywordType()->isAll();
    }

    /**
     * @return Query[]
     */
    public function getQuery(): array
    {
        return $this->queries;
    }

    public function equal(ValueObject $value): bool
    {
        if (get_class($this) !== get_class($value)) {
            return false;
        }

        if (count($this->queries) !== count($value->queries)) {
            return false;
        }

        foreach ($this->queries as $key => $query) {
            if (!$query->equal($value->queries[$key])) {
                return false;
            }
        }

        return true;
    }

    public function __toString(): string
    {
        return 'SearchQuery';
    }
}
