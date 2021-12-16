<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\User\ProvisionalUser;

use Carbon\Carbon;
use Lee\Live\Shared\ValueObject;

final class ProvisionalDate implements ValueObject
{
    private Carbon $value;
    private const EXPIRE_MAX_SECONDS = 3600;

    public function __construct(?string $date = null)
    {
        $this->value = is_null($date) ? Carbon::now() : Carbon::createFromTimeString($date);
    }

    public static function createNow(): self
    {
        return new self;
    }

    public function showExpiredDate(string $dateFormat): string
    {
        return $this->value->addHour()->format($dateFormat);
    }

    public function isExpired(Carbon $current): bool
    {
        return $this->value->diffInSeconds($current) > self::EXPIRE_MAX_SECONDS;
    }

    public function equal(ValueObject $value): bool
    {
        return get_class($this) === get_class($value) && $this->value->eq($value->value);
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
