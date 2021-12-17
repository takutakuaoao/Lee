<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User\ProvisionalUser;

use Carbon\Carbon;

final class ValidFormalRegistrationDatePolicy
{
    public function __construct(
        private Carbon $formalRegistrationDate
    ) {
    }

    public function satisfiedBy(ProvisionalUser $provisionalUser): bool
    {
        return $provisionalUser->canFormalRegistration($this->formalRegistrationDate);
    }
}
