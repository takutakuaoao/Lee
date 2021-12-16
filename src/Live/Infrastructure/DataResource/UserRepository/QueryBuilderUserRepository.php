<?php

declare(strict_types=1);

namespace Lee\Live\Infrastructure\DataResource\UserRepository;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\User;
use Lee\Live\Domain\Model\User\UserFactory;
use Lee\Live\Domain\Model\User\UserId;
use Lee\Live\Domain\Model\User\UserRepository;
use Lee\Live\Domain\Model\User\UserType;

final class QueryBuilderUserRepository implements UserRepository
{
    /**
     * @param  ArtistId    $artistId
     * @return User[]|null
     */
    public function findByArtistId(ArtistId $artistId): ?array
    {
        $query = DB::table('users')
            ->leftJoin('favorite_artists', 'users.id', '=', 'favorite_artists.user_id')
            ->where('favorite_artists.artist_id', '=', $artistId);

        if (!$query->exists()) {
            return null;
        }

        return $this->fetchUserWithArtistIds($query);
    }

    /**
     * @param  ArtistId[]  $artistIds
     * @return User[]|null
     */
    public function findByMultipleArtistId(array $artistIds): ?array
    {
        foreach ($artistIds as $artistId) {
            if (!($artistId instanceof ArtistId)) {
                throw new InvalidArgumentException('');
            }
        }

        $query = DB::table('users')
            ->leftJoin('favorite_artists', 'users.id', '=', 'favorite_artists.user_id')
            ->whereIn('favorite_artists.artist_id', array_map(fn (ArtistId $artistId) => (string)$artistId, $artistIds))
            ->groupBy('users.id');

        if (!$query->exists()) {
            return null;
        }

        return $this->fetchUserWithArtistIds($query);
    }

    private function fetchUserWithArtistIds(Builder $query): array
    {
        if (!$query->exists()) {
            throw new InvalidArgumentException('FetchUserWithArtistIds method must be existed query.');
        }

        $users = $query->get()->map(function ($user) {
            $artistIds = DB::table('favorite_artists')->where('user_id', '=', $user->id)->get(['artist_id']);

            return (new UserFactory)->createUser(
                new UserId($user->id),
                new Email($user->email),
                UserType::createFromPrimitive((int)$user->type),
                $artistIds->map(fn ($artistId) => new ArtistId($artistId->artist_id))->toArray(),
            );
        });

        return $users->toArray();
    }
}
