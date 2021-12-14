<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User;

use Lee\Live\Domain\Model\Artist\ArtistId;

final class User
{
    /** @var ArtistId[] */
    private array $artistIds;

    private UserHasArtistSpecification $artistSpecification;

    /**
     * @param UserId     $userId
     * @param Email      $email
     * @param UserType   $userType
     * @param ArtistId[] $artistIds
     */
    public function __construct(
        private UserId $userId,
        private Email $email,
        private UserType $userType,
        array $artistIds = [],
    ) {
        $this->artistSpecification = new UserHasArtistSpecification;

        if (!$this->artistSpecification->isSatisfiedBy($userType, ...$artistIds)) {
            throw new UserSpecificationException('');
        }

        $this->artistIds = $artistIds;
    }

    public function registerArtist(ArtistId $artistId): self
    {
        if (!$this->artistSpecification->isSatisfiedBy($this->userType, ...$this->artistIds, ...[$artistId])) {
            throw new UserSpecificationException('');
        }

        $this->artistIds[] = $artistId;

        return $this;
    }

    /**
     * @param  ArtistId[]      $artistIds
     * @return ArtistId[]|null
     */
    public function selectFavoriteArtist(array $artistIds): ?array
    {
        if ($this->artistIds === []) {
            return null;
        }

        $matchedArtistId = array_filter($artistIds, function(ArtistId $artistId) {
            return $artistId->isContain($this->artistIds);
        });

        if ($matchedArtistId === []) {
            return null;
        }

        return $matchedArtistId;
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
            'artistIds' => array_map(function (ArtistId $aArtistId) {
                return (string)$aArtistId;
            }, $this->artistIds),
        ];
    }
}
