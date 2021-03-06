<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User;

use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\User\AuthUser\AuthUser;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalUser;

final class UserFactory
{
    /**
     * @param  UserId     $id
     * @param  Email      $email
     * @param  UserType   $type
     * @param  ArtistId[] $artistIds
     * @return User
     */
    public function createUser(UserId $id, Email $email, UserType $type, array $artistIds = []): User
    {
        return new User(
            $id,
            $email,
            $type,
            new FavoriteArtists($artistIds),
        );
    }

    public function createGeneralUser(Email $email): User
    {
        return new User(
            new UserId(uniqid('', true)),
            $email,
            UserType::general()
        );
    }

    public function createPremiumUser(Email $email): User
    {
        return new User(
            new UserId(uniqid('', true)),
            $email,
            UserType::premium()
        );
    }

    public function createFormalRegistrationUser(ProvisionalUser $provisionalUser): AuthUser
    {
        $user = new User(
            $provisionalUser->getUserId(),
            $provisionalUser->getEmail(),
            UserType::general(),
        );

        return new AuthUser($user, $provisionalUser->getPassword());
    }
}
