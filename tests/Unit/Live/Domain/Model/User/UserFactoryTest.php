<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Domain\Model\User;

use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\Password;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalDate;
use Lee\Live\Domain\Model\User\ProvisionalUser\ProvisionalUserFactory;
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

    public function test_create_formal_registration_user(): void
    {
        $provisionalUser = (new ProvisionalUserFactory)->create(
            new UserId('test'),
            new Email('test@test.com'),
            Password::createHashed('test'),
            new ProvisionalDate('2021/01/01 00:00:00'),
        );

        $authUser = (new UserFactory)->createFormalRegistrationUser($provisionalUser);

        $primitives = $authUser->toPrimitives();
        $expect     = [
            'id'        => 'test',
            'email'     => 'test@test.com',
            'userType'  => 1,
            'artistIds' => [],
            'password'  => 'test',
        ];

        $this->assertEquals($expect, $primitives);
    }
}
