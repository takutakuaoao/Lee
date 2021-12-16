<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Domain\Model\User;

use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\UserFactory;
use Lee\Live\Domain\Model\User\UserId;
use Lee\Live\Domain\Model\User\UserType;
use PHPUnit\Framework\TestCase;

class UserFactoryTest extends TestCase
{
    public function test_create_general_user(): void
    {
        $user = (new UserFactory)->createGeneralUser(
            new Email('test@test.com'),
        );

        $this->assertEquals('1', $user->toPrimitive()['userType']);
        $this->assertEquals('test@test.com', $user->toPrimitive()['email']);
        $this->assertEquals([], $user->toPrimitive()['artistIds']);
    }

    public function test_create_premium(): void
    {
        $user = (new UserFactory)->createPremiumUser(
            new Email('test@test.com'),
        );

        $this->assertEquals('2', $user->toPrimitive()['userType']);
        $this->assertEquals('test@test.com', $user->toPrimitive()['email']);
        $this->assertEquals([], $user->toPrimitive()['artistIds']);
    }

    public function test_create_user(): void
    {
        $user = (new UserFactory)->createUser(
            new UserId('user-id'),
            new Email('test@test.com'),
            UserType::general(),
            [new ArtistId('artist-1')],
        );

        $this->assertEquals('user-id', $user->toPrimitive()['id']);
        $this->assertEquals('1', $user->toPrimitive()['userType']);
        $this->assertEquals('test@test.com', $user->toPrimitive()['email']);
        $this->assertEquals('artist-1', $user->toPrimitive()['artistIds'][0]);
    }
}
