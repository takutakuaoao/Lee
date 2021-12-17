<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User;

use Lee\Live\Domain\Model\Artist\ArtistId;

final class User
{
    private UserHasArtistSpecification $artistSpecification;
    private FavoriteArtists $favoriteArtists;

    public function __construct(
        private UserId $userId,
        private Email $email,
        private UserType $userType,
        ?FavoriteArtists $favoriteArtists = null,
    ) {
        $this->artistSpecification = new UserHasArtistSpecification;
        $this->favoriteArtists     = is_null($favoriteArtists) ? new FavoriteArtists([]) : $favoriteArtists;

        if (!$this->artistSpecification->isSatisfiedBy($this->favoriteArtists, $userType)) {
            throw new UserSpecificationException('');
        }
    }

    public function registerFavorite(ArtistId $artistId): self
    {
        if (!$this->artistSpecification->isSatisfiedBy($favoriteArtists = $this->favoriteArtists->add($artistId), $this->userType)) {
            throw new UserSpecificationException('');
        }

        $this->favoriteArtists = $favoriteArtists;

        return $this;
    }

    /**
     * @param  ArtistId[]      $liveActors
     * @return ArtistId[]|null
     */
    public function fetchLiveActedFavoriteArtist(array $liveActors): ?array
    {
        if (is_null($liveActedFavoriteArtists = $this->favoriteArtists->selectFavoriteArtist($liveActors))) {
            return null;
        }

        return $liveActedFavoriteArtists->getArtistIds();
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function toPrimitive(): array
    {
        return [
            'id'        => (string)$this->userId,
            'email'     => (string)$this->email,
            'userType'  => (string)$this->userType,
            'artistIds' => $this->favoriteArtists->toArray(),
        ];
    }

    public function sameAs(User $user): bool
    {
        return $this->userId->equal($user->userId);
    }
}
