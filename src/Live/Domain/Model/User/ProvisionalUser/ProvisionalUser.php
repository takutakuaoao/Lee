<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User\ProvisionalUser;

use Carbon\Carbon;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\Password;
use Lee\Live\Domain\Model\User\UserId;

final class ProvisionalUser
{
    public function __construct(
        private UserId $userId,
        private Email $email,
        private Password $password,
        private ProvisionalDate $provisionalDate,
    ) {
    }

    public function canFormalRegistration(Carbon $formalRegistrationDate): bool
    {
        return !$this->provisionalDate->isExpired($formalRegistrationDate);
    }

    public function toDto(): ProvisionalUserDto
    {
        return new ProvisionalUserDto(
            (string)$this->userId,
            (string)$this->email,
            $this->password->getValue(),
            (string)$this->provisionalDate,
        );
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function sameAs(ProvisionalUser $provisionalUser): bool
    {
        return $this->userId->equal($provisionalUser->userId);
    }
}
