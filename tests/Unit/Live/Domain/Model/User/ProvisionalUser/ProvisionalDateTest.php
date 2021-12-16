<?php

namespace Tests\Unit\Live\Domain\Model\User\ProvisionalUser;

use Carbon\Carbon;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalDate;
use PHPUnit\Framework\TestCase;

class ProvisionalDateTest extends TestCase
{
    public function test_equal(): void
    {
        $date = new ProvisionalDate('2021/01/01 00:00:00');
        $this->assertTrue($date->equal(new ProvisionalDate('2021/01/01 00:00:00')));
    }

    public function test_is_expired(): void
    {
        $date = new ProvisionalDate('2021/01/01 00:00:00');
        $this->assertTrue($date->isExpired(Carbon::createFromTimeString('2021/01/01 01:00:01')));
        $this->assertFalse($date->isExpired(Carbon::createFromTimeString('2021/01/01 01:00:00')));
    }

    public function test_show_expired_date(): void
    {
        $date = new ProvisionalDate('2021/01/01 00:00:00');
        $this->assertEquals('2021/01/01 01:00:00', $date->showExpiredDate('Y/m/d H:i:s'));
    }
}
