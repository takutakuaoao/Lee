<?php

namespace Tests\Unit\Live\Domain\Model\User\ProvisionalUser;

use InvalidArgumentException;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\Password;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalUser;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalUserFactory;
use PHPUnit\Framework\TestCase;

class ProvisionalUserFactoryTest extends TestCase
{
    public function test_create_new(): void
    {
        $user = (new ProvisionalUserFactory)->createNew(
            new Email('test@test.com'),
            Password::createNew('password@123'),
        );

        $this->assertTrue($user instanceof ProvisionalUser);
    }

    public function test_throw_exception_when_given_hashed_password(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new ProvisionalUserFactory)->createNew(
            new Email('test@test.com'),
            Password::createHashed('password@123'),
        );
    }
}
