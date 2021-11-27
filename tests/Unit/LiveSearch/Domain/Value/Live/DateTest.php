<?php

namespace Tests\Unit\LiveSearch\Domain\Value\Live;

use InvalidArgumentException;
use Lee\LiveSearch\Domain\Value\Live\Date;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    public function test_to_string(): void
    {
        $date = new Date(2021, 1, 1, 17, 10);

        $this->assertEquals('2021/01/01 17:10:00', $date);
    }

    public function test_to_string_0_hour(): void
    {
        $date = new Date(2021, 1, 1, 0, 0);

        $this->assertEquals('2021/01/01 00:00:00', $date);
    }

    public function test_new_instance_0_prefix_value(): void
    {
        $date = new Date(2021, 01, 01, 00, 01);

        $this->assertEquals('2021/01/01 00:01:00', $date);
    }

    public function test_to_string_when_arguments_float_value(): void
    {
        $date = new Date(2021, 1.1, 1.6, 23.9, 1.5);

        $this->assertEquals('2021/01/01 23:01:00', $date);
    }

    /**
     * @dataProvider validateDataProvider
     * @param int $y
     * @param int $m
     * @param int $d
     * @param int $h
     * @param int $i
     *
     * @return void
     */
    public function test_validate(int $y, int $m, int $d, int $h, int $i): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Date::makeErrorMessage($y, $m, $d, $h, $i));

        new Date($y, $m, $d, $h, $i);
    }

    public function validateDataProvider(): array
    {
        return [
            [0, 1, 1, 1, 1],
            [2000, 0, 1, 1, 1],
            [2000, 13, 1, 1, 1],
            [2000, 1, 0, 1, 1],
            [2000, 1, 32, 1, 1],
            [2000, 1, 1, -1, 1],
            [2000, 1, 1, 25, 1],
            [2000, 1, 1, 1, -1],
            [2000, 1, 1, 1, 61],
            [2000, 2, 31, 1, 1],
        ];
    }
}
