<?php

namespace Tests\Unit\LiveSearch\Domain\Value\Live;

use Lee\LiveSearch\Domain\Value\Live\Prefecture;
use PHPUnit\Framework\TestCase;

class PrefectureTest extends TestCase
{
    public function test_to_string(): void
    {
        $prefecture = new Prefecture('北海道');

        $this->assertEquals('北海道', $prefecture);
    }
}
