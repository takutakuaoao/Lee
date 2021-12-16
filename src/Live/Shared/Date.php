<?php

declare(strict_types=1);

namespace Lee\Live\Shared;

use Carbon\Carbon;
use Exception;
use InvalidArgumentException;
use Lee\Live\Shared\ValueObject;

class Date implements ValueObject
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

    /**
     * 配列から生成
     *
     * @param  array  $date
     * @return static
     */
    public static function factoryFromArray(array $date): static
    {
        if (count($date) > 5 || self::validate($date[0], $date[1], $date[2], $date[3], $date[4])) {
            throw new InvalidArgumentException('Invalid date value.');
        }

        return new static($date[0], $date[1], $date[2], $date[3], $date[4]);
    }

    /**
     * 日付文字列から生成
     *
     * @param string $date
     * @return self
     */
    public static function factoryFromString(string $date): self
    {
        try {
            $carbon = Carbon::createFromTimeString($date);
        } catch(Exception $e) {
            throw new InvalidArgumentException("Argument of factoryFromString must be convertible to date: {$date}");
        }

        return new self($carbon->year, $carbon->month, $carbon->day, $carbon->hour, $carbon->minute);
    }

    public function format(string $formatPattern): string
    {
        return $this->value->format($formatPattern);
    }

    /**
     * 日時比較（比較対象未満）
     *
     * @param  Date    $date
     * @return boolean
     */
    public function isBefore(Date $date): bool
    {
        return $this->value->lt($date->value);
    }

    /**
     * 日時比較（比較対象以下）
     *
     * @param  Date    $date
     * @return boolean
     */
    public function isUntil(Date $date): bool
    {
        return $this->value->lte($date->value);
    }

    /**
     * 日時比較（比較対象より後）
     *
     * @param  Date    $date
     * @return boolean
     */
    public function isAfter(Date $date): bool
    {
        return $this->value->gt($date->value);
    }

    /**
     * 日時比較（比較対象以上）
     *
     * @param  Date    $date
     * @return boolean
     */
    public function isSince(Date $date): bool
    {
        return $this->value->gte($date->value);
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

    public function equal(ValueObject $value): bool
    {
        return get_class($this) === get_class($value) && $this->value->eq($value->value);
    }

    public function __toString()
    {
        return $this->value->format('Y/m/d H:i:00');
    }
}
