<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Domain\Model\Live;

use Lee\Live\Domain\Model\Live\LiveHouse\Address;
use Lee\Live\Domain\Model\Live\LiveHouse\LiveHouse;
use Lee\Live\Domain\Model\Live\LiveHouse\Location;
use Lee\Live\Domain\Model\Live\LiveHouse\Prefecture;
use Lee\Live\Shared\Name;
use PHPUnit\Framework\TestCase;

class LiveHouseTest extends TestCase
{
    public function test_to_string(): void
    {
        $location  = new Location(new Prefecture('北海道'), new Address('住所'));
        $liveHouse = new LiveHouse(new Name('test live house'), $location);

        $this->assertEquals('ライブハウス名: test live house, 所在地: 北海道 住所', $liveHouse);
    }
}
