<?php

namespace Tests\Unit\LiveSearch\Domain\Value\Location;

use Lee\LiveSearch\Domain\Value\Location\Address;
use Lee\LiveSearch\Domain\Value\Location\Location;
use Lee\LiveSearch\Domain\Value\Location\Prefecture;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function test_to_string(): void
    {
        $location = new Location(new Prefecture('東京'), new Address('test'));

        $this->assertEquals('東京 test', $location);
    }
}
