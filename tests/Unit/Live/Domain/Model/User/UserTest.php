<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Domain\Model\User;

use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\FavoriteArtists;
use Lee\Live\Domain\Model\User\User;
use Lee\Live\Domain\Model\User\UserFactory;
use Lee\Live\Domain\Model\User\UserId;
use Lee\Live\Domain\Model\User\UserSpecificationException;
use Lee\Live\Domain\Model\User\UserType;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_create_instance(): void
    {
        $user = new User(new UserId(1), new Email('test@test.com'), UserType::general());

        $this->assertTrue($user instanceof User);
    }

    public function test_throw_exception_to_violation_to_artist_specification(): void
    {
        $this->expectException(UserSpecificationException::class);

        new User(new UserId(1), new Email('test@test.com'), UserType::general(), new FavoriteArtists([new ArtistId('1'), new ArtistId('1')]));
    }

    public function test_register_favorite(): void
    {
        $user = new User(new UserId(1), new Email('test@test.com'), UserType::general());
        $user->registerFavorite(new ArtistId('1'));

        $userPrimitive = $user->toPrimitive();

        $this->assertEquals($userPrimitive['artistIds'][0], 1);
        $this->assertEquals(1, count($userPrimitive['artistIds']));
    }

    public function test_throw_exception_to_added_duplicate_artist(): void
    {
        $this->expectException(UserSpecificationException::class);

        $user = new User(new UserId(1), new Email('test@test.com'), UserType::general(), new FavoriteArtists([new ArtistId('1')]));
        $user->registerFavorite(new ArtistId('1'));
    }
}
