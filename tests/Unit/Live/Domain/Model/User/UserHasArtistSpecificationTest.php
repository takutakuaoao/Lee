<?php

namespace Tests\Unit\Live\Domain\Model\User;

use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\User\FavoriteArtists;
use Lee\Live\Domain\Model\User\UserHasArtistSpecification;
use Lee\Live\Domain\Model\User\UserType;
use PHPUnit\Framework\TestCase;

class UserHasArtistSpecificationTest extends TestCase
{
    public function test_is_satisfied_by(): void
    {
        $specification = new UserHasArtistSpecification;

        $this->assertTrue($specification->isSatisfiedBy(new FavoriteArtists([new ArtistId(1), new ArtistId(2)]), UserType::general()));
    }

    public function test_user_general_type_but_has_over_max_artist(): void
    {
        $specification = new UserHasArtistSpecification;

        $this->assertFalse($specification->isSatisfiedBy(new FavoriteArtists([new ArtistId(1), new ArtistId(2), new ArtistId(3), new ArtistId(4), new ArtistId(5), new ArtistId(6)]), UserType::general()));
    }

    public function test_ok_premium_user_has_over_max_artists(): void
    {
        $specification = new UserHasArtistSpecification;

        $this->assertTrue($specification->isSatisfiedBy(new FavoriteArtists([new ArtistId(1), new ArtistId(2), new ArtistId(3), new ArtistId(4), new ArtistId(5), new ArtistId(6)]), UserType::premium()));
    }

    public function test_failed_duplicate_artists(): void
    {
        $specification = new UserHasArtistSpecification;

        $this->assertFalse($specification->isSatisfiedBy(new FavoriteArtists([new ArtistId(1), new ArtistId(1)]), UserType::premium()));
    }

    public function test_safe_empty_artists(): void
    {
        $specification = new UserHasArtistSpecification;

        $this->assertTrue($specification->isSatisfiedBy(new FavoriteArtists([]), UserType::general()));
    }
}
