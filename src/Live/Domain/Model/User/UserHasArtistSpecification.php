<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User;

use InvalidArgumentException;
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

    public function isSatisfiedBy(UserType $userType, ArtistId ...$artistId): bool
    {
        if ($this->isDuplicateArtistId(...$artistId)) {
            return false;
        }

        return !$this->hasOverMaxArtists($userType, ...$artistId);
    }

    private function isDuplicateArtistId(ArtistId ...$artistId): bool
    {
        if ($artistId === []) {
            return false;
        }

        $artistIds = array_map(function(ArtistId $aArtistId) {
            return $aArtistId->getValue();
        }, $artistId);

        return $artistIds !== array_unique($artistIds);
    }

    private function hasOverMaxArtists(UserType $userType, ArtistId ...$artistId): bool
    {
        return $userType->isGeneral() && count($artistId) > self::MAX_ARTIST_COUNT;
    }
}
