<?php

declare(strict_types=1);

namespace Lee\Live\Application\Search\SearchQuery;

use Lee\Live\Shared\Enum;

/**
 * @method static SearchType allSearch()
 * @method static SearchType equalSearch()
 * @method static SearchType partialSearch()
 * @method static SearchType moreThanSearch()
 * @method bool   isAllSearch()
 * @method bool   isEqualSearch()
 * @method bool   isPartialSearch()
 * @method bool   isMoreThanSearch()
 */
final class SearchType extends Enum
{
    private const ALL_SEARCH       = 0;
    private const EQUAL_SEARCH     = 1;
    private const PARTIAL_SEARCH   = 2;
    private const MORE_THAN_SEARCH = 3;
}
