<?php

namespace Tests\Unit\LiveSearch\Domain\Value;

use InvalidArgumentException;
use Lee\LiveSearch\Domain\Value\Date;
use Lee\LiveSearch\Domain\Value\TimeSchedule;
use PHPUnit\Framework\TestCase;

class TimeScheduleTest extends TestCase
{
    public function test_to_string(): void
    {
        $timeSchedule = new TimeSchedule(new Date(2021, 1, 1, 17, 00), new Date(2021, 1, 1, 17, 30), new Date(2021, 1, 1, 19, 00));

        $this->assertEquals('[open] 2021/01/01 17:00:00 [start] 2021/01/01 17:30:00 [end] 2021/01/01 19:00:00', $timeSchedule);
    }

    /**
     * @dataProvider validateDataProvider
     * @param Date $open
     * @param Date $start
     * @param Date $end
     * @return void
     */
    public function test_validate(Date $open, Date $start, Date $end): void
    {
        $this->expectException(InvalidArgumentException::class);
        new TimeSchedule($open, $start, $end);
    }

    public function test_new_instance_start_is_null(): void
    {
        $timeSchedule = new TimeSchedule(new Date(2021, 1, 1, 17, 00), null, new Date(2021, 1, 1, 18, 00));

        $this->assertEquals('[open] 2021/01/01 17:00:00 [start] 2021/01/01 17:00:00 [end] 2021/01/01 18:00:00', $timeSchedule);
    }

    public function validateDataProvider(): array
    {
        return [
            [new Date(2021, 1, 1, 17, 00), new Date(2021, 1, 1, 16, 00), new Date(2021, 1, 1, 17, 30)],
            [new Date(2021, 1, 1, 17, 00), new Date(2021, 1, 1, 17, 30), new Date(2021, 1, 1, 17, 00)],
            [new Date(2021, 1, 1, 17, 00), new Date(2021, 1, 1, 17, 30), new Date(2021, 1, 1, 16, 00)],
        ];
    }
}
