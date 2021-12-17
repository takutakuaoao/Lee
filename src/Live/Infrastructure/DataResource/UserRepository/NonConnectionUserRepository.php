<?php

declare(strict_types=1);

namespace Lee\Live\Infrastructure\DataResource\UserRepository;

use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\User;
use Lee\Live\Domain\Model\User\UserFactory;
use Lee\Live\Domain\Model\User\UserRepository;

final class NonConnectionUserRepository implements UserRepository
{
    /** @var User[]|null */
    public ?array $returnUsers;

    public bool $returnBool = false;

    public function __construct()
    {
        $factory = new UserFactory;
        $this->returnUser = [$factory->createGeneralUser(new Email('test@test.com'))];
    }

    /**
     * @param  ArtistId    $artistId
     * @return User[]|null
     */
    public function findByArtistId(ArtistId $artistId): ?array
    {
        return $this->returnUsers;
    }

    /**
     * @param  ArtistId[]  $artistIds
     * @return User[]|null
     */
    public function findByMultipleArtistId(array $artistIds): ?array
    {
        return $this->returnUsers;
    }

    public function existsByEmail(Email $email): bool
    {
        return $this->returnBool;
    }
}
