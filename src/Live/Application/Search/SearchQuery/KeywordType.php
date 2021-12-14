<?php

declare(strict_types=1);

namespace Lee\Live\Application\Search\SearchQuery;

use Lee\Live\Shared\Enum;

/**
 * @method static KeywordType all()
 * @method static KeywordType artistName()
 * @method static KeywordType liveHouseName()
 * @method static KeywordType liveStartDate()
 * @method static KeywordType prefecture()
 * @method bool   isAll()
 * @method bool   isArtistName()
 * @method bool   isLiveHouseName()
 * @method bool   isLiveStartDate()
 * @method bool   isPrefecture()
 */
final class KeywordType extends Enum
{
    private const ALL             = 0;
    private const ARTIST_NAME     = 1;
    private const LIVE_HOUSE_NAME = 2;
    private const LIVE_START_DATE = 3;
    private const PREFECTURE      = 4;
}
