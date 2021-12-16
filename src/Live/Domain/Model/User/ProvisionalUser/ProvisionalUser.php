<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User\ProvisionalUser;

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

    public function toDto(): ProvisionalUserDto
    {
        return new ProvisionalUserDto(
            (string)$this->userId,
            (string)$this->email,
            $this->password->getValue(),
            (string)$this->provisionalDate,
        );
    }

    public function sameAs(ProvisionalUser $provisionalUser): bool
    {
        return $this->userId->equal($provisionalUser->userId);
    }
}
