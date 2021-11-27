<?php

namespace Tests\Unit\LiveSearch\Domain\Value\Live;

use InvalidArgumentException;
use Lee\LiveSearch\Domain\Value\Live\Name;
use PHPUnit\Framework\TestCase;

use function Lee\makeString;

class NameTest extends TestCase
{
    public function test_to_string(): void
    {
        $name = new Name('test');

        $this->assertEquals('test', $name);
    }

    public function test_empty_validate(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Name('');
    }

    public function test_over_100_len_name_validate(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Name(makeString(101));
    }

    public function test_over_100_len_name_contain_space_validate(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Name(makeString(50) . ' ' . makeString(50));
    }

    public function test_just_100_len_name(): void
    {
        $name = new Name(makeString(100));

        $this->assertEquals(makeString(100), $name);
    }

    public function test_trim_new_instance(): void
    {
        $name = new Name(' ' . makeString(100) . ' ');

        $this->assertEquals(makeString(100), $name);
    }
}
