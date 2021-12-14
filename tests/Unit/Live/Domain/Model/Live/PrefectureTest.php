<?php

namespace Tests\Unit\Live\Domain\Model\Live;

use InvalidArgumentException;
use Lee\Live\Domain\Model\Live\LiveHouse\Prefecture;
use PHPUnit\Framework\TestCase;

class PrefectureTest extends TestCase
{
    public function test_to_string(): void
    {
        $prefecture = new Prefecture('北海道');

        $this->assertEquals('北海道', $prefecture);
    }

    public function test_trim(): void
    {
        $prefecture = new Prefecture(' 東京都 ');
        $this->assertEquals('東京', $prefecture);

        $prefecture = new Prefecture('京都府 ');
        $this->assertEquals('京都', $prefecture);

        $prefecture = new Prefecture(' 青森県');
        $this->assertEquals('青森', $prefecture);
    }

    public function test_validate(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Prefecture('not prefecture');
    }
}
