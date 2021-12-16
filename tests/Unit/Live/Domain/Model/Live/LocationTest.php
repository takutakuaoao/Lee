<?php

namespace Tests\Unit\Live\Domain\Model\Live;

use Lee\Live\Domain\Model\Live\LiveHouse\Address;
use Lee\Live\Domain\Model\Live\LiveHouse\Location;
use Lee\Live\Domain\Model\Live\LiveHouse\Prefecture;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function test_to_string(): void
    {
        $location = new Location(new Prefecture('東京'), new Address('test'));

        $this->assertEquals('東京 test', $location);
    }
}
