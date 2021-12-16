<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User;

use Lee\Live\Domain\Model\Artist\ArtistId;

/**
 * ユーザーのアーティスト情報保持仕様
 * 1. アーティストIDは重複しない
 * 2. 一般ユーザーは5件までアーティストを保持できる
 * 3. プレミアムユーザーは2.の制限を受けない
 */
final class UserHasArtistSpecification
{
    private const MAX_ARTIST_COUNT = 5;

    public function isSatisfiedBy(FavoriteArtists $favoriteArtists, UserType $userType): bool
    {
        if (!$favoriteArtists->isAllUnique()) {
            return false;
        }

        return !$this->hasOverMaxArtists($userType, $favoriteArtists);
    }

    private function hasOverMaxArtists(UserType $userType, FavoriteArtists $favoriteArtists): bool
    {
        return $userType->isGeneral() && $favoriteArtists->count() > self::MAX_ARTIST_COUNT;
    }
}
