<?php

namespace Lee\LiveSearch\Domain\Value\Live;

use Carbon\Carbon;
use InvalidArgumentException;

class Date
{
    private const DOWN_CAST_HOUR    = 24; // 0時に変換する時間
    private const DOWN_CAST_MINUTES = 60; // 0分に変換する分

    /** @var Carbon */
    private $value;

    public function __construct(int $y, int $m, int $d, int $h, int $i)
    {
        if ($h === self::DOWN_CAST_HOUR) {
            $h = 0;
        }

        if ($i === self::DOWN_CAST_MINUTES) {
            $i = 0;
        }

        if (self::validate($y, $m, $d, $h, $i)) {
            throw new InvalidArgumentException(self::makeErrorMessage($y, $m, $d, $h, $i));
        }

        $this->value = Carbon::create($y, $m, $d, $h, $i);
    }

    public static function makeErrorMessage(int $y, int $m, int $d, int $h, int $i): string
    {
        return 'Invalid date : ' . $y . '/' . $m . '/' . $d . ' ' . $h . ':' . $i;
    }

    /**
     * 日付が正しいか判定
     *
     * @param int $y
     * @param int $m
     * @param int $d
     * @param int $h
     * @param int $i
     *
     * @return bool
     */
    private static function validate(int $y, int $m, int $d, int $h, int $i): bool
    {
        return $y < 1900 ||
               ($m < 1 || $m > 12) ||
               ($d < 1 || $d > 31) ||
               ($h < 0 || $h > 24) ||
               ($i < 0 || $i > 60) ||
               !checkdate($m, $d, $y);
    }

    public function __toString()
    {
        return $this->value->format('Y/m/d H:i:00');
    }
}
