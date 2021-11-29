<?php

namespace Tests\Unit\LiveSearch\Domain\Value\Location;

use InvalidArgumentException;
use Lee\LiveSearch\Domain\Value\Location\Address;
use PHPUnit\Framework\TestCase;

use function Lee\makeString;

class AddressTest extends TestCase
{
    public function test_to_string(): void
    {
        $address = new Address('test address');

        $this->assertEquals('test address', $address);
    }

    public function test_trim_when_new_instance(): void
    {
        $address = new Address(' test address ');

        $this->assertEquals('test address', $address);
    }

    /**
     * @dataProvider addressDataProvider
     * @param string $address
     * @return void
     */
    public function test_validate(string $address): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Address($address);
    }

    public function addressDataProvider(): array
    {
        return [
            [''],
            [makeString(501)],
            [makeString(100) . ' ' . makeString(400)],
        ];
    }
}
