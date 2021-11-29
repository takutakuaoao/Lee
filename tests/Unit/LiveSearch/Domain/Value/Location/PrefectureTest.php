<?php

namespace Tests\Unit\LiveSearch\Domain\Value\Location;

use InvalidArgumentException;
use Lee\LiveSearch\Domain\Value\Location\Prefecture;
use PHPUnit\Framework\TestCase;

class PrefectureTest extends TestCase
{
    public function test_to_string(): void
    {
        $prefecture = new Prefecture('北海道');

        $this->assertEquals('北海道', $prefecture);
    }

    public function test_validate(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Prefecture('not prefecture');
    }
}
