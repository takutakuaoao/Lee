<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User\ProvisionalUser;

final class FormalRegisterPolicy
{
    public function __construct(
        private ValidFormalRegistrationDatePolicy $validFormalRegistrationDatePolicy,
        private UniqueEmailPolicy $uniqueEmailPolicy,
    ) {
    }

    public function satisfiedBy(ProvisionalUser $provisionalUser): bool
    {
        return $this->validFormalRegistrationDatePolicy->satisfiedBy($provisionalUser) &&
            $this->uniqueEmailPolicy->satisfiedBy($provisionalUser);
    }
}
