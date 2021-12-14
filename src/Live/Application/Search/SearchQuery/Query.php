<?php

declare(strict_types=1);

namespace Lee\Live\Application\Search\SearchQuery;

use Lee\Live\Shared\ValueObject;

class Query implements ValueObject
{
    public function __construct(
        private KeywordType $keywordType,
        private SearchType $searchType,
        private string $value,
    ) {
    }

    public function getKeywordType(): KeywordType
    {
        return $this->keywordType;
    }

    public function getSearchType(): SearchType
    {
        return $this->searchType;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equal(ValueObject $value): bool
    {
        if (get_class($this) !== get_class($value)) {
            return false;
        }

        return $this->keywordType->equal($value->keywordType) &&
            $this->searchType->equal($value->searchType) &&
            $this->value === $value->value;
    }

    public function __toString(): string
    {
        return 'query';
    }
}
