<?php

namespace Tests\Unit\Live\Domain\Model\User\AuthUser;

use Lee\Live\Domain\Model\User\AuthUser\AuthUser;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\Password;
use Lee\Live\Domain\Model\User\UserFactory;
use PHPUnit\Framework\TestCase;

class AuthUserTest extends TestCase
{
    public function test_same_as(): void
    {
        $authUser = new AuthUser(
            (new UserFactory())->createGeneralUser(new Email('test@test.com')),
            Password::createHashed('test'),
        );

        $this->assertTrue($authUser->sameAs($authUser));
    }
}
