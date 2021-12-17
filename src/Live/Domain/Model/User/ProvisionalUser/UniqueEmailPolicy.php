<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User\ProvisionalUser;

use Lee\Live\Domain\Model\User\UserRepository;

final class UniqueEmailPolicy
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function satisfiedBy(ProvisionalUser $provisionalUser): bool
    {
        return !$this->userRepository->existsByEmail($provisionalUser->getEmail());
    }
}
