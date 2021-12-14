<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User;

use Lee\Live\Shared\Enum;

/**
 * @method static UserType general()
 * @method static UserType premium()
 * @method bool   isGeneral()
 * @method bool   isPremium()
 */
final class UserType extends Enum
{
    private const GENERAL = 1;
    private const PREMIUM = 2;

    public static function createFromPrimitive(int $status): self
    {
        return new UserType($status);
    }
}
