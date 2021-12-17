<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User\ProvisionalUser;

use InvalidArgumentException;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\Password;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalDate;
use Lee\Live\Domain\Model\User\UserId;

final class ProvisionalUserFactory
{
    public function createNew(Email $email, Password $password): ProvisionalUser
    {
        static::mustPasswordNotHash($password);

        return new ProvisionalUser(
            UserId::issueNewId(),
            $email,
            $password,
            ProvisionalDate::createNow(),
        );
    }

    public function create(UserId $userId, Email $email, Password $password, ProvisionalDate $provisionalDate): ProvisionalUser
    {
        return new ProvisionalUser(
            $userId,
            $email,
            $password,
            $provisionalDate,
        );
    }

    private static function mustPasswordNotHash(Password $password): void
    {
        if (!$password->isRawPassword()) {
            throw new InvalidArgumentException('');
        }
    }
}
