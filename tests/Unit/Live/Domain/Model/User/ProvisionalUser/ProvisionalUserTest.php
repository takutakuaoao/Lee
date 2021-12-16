<?php

namespace Tests\Unit\Live\Domain\Model\User\ProvisionalUser;

use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\Password;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalDate;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalUser;
use Lee\Live\Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;

class ProvisionalUserTest extends TestCase
{
    public function test_same_as(): void
    {
        $provisionalUser = new ProvisionalUser(
            new UserId('test'),
            new Email('test@test.com'),
            Password::createNew('password@12'),
            new ProvisionalDate('2021/01/01 00:00:00'),
        );

        $this->assertTrue($provisionalUser->sameAs(new ProvisionalUser(
            new UserId('test'),
            new Email('test1@test.com'),
            Password::createNew('password@123'),
            new ProvisionalDate('2021/01/02 00:00:00'),
        )));

        $this->assertFalse($provisionalUser->sameAs(new ProvisionalUser(
            new UserId('test1'),
            new Email('test1@test.com'),
            Password::createNew('password@123'),
            new ProvisionalDate('2021/01/02 00:00:00'),
        )));
    }
}
