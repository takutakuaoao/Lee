<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User\AuthUser;

use Lee\Live\Domain\Model\User\Password;
use Lee\Live\Domain\Model\User\User;

final class AuthUser
{
    public function __construct(
        private User $user,
        private Password $password,
    ) {
    }

    public function toPrimitives(): array
    {
        return array_merge($this->user->toPrimitive(), ['password' => $this->password->getValue()]);
    }

    public function sameAs(AuthUser $authUser): bool
    {
        return $this->user->sameAs($authUser->user);
    }
}
