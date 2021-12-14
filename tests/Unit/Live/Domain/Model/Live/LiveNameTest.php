<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Domain\Model\Live;

use Lee\Live\Domain\Model\Live\LiveName;
use PHPUnit\Framework\TestCase;

class LiveNameTest extends TestCase
{
    public function test_equal(): void
    {
        $liveName = new LiveName('test');

        $this->assertTrue($liveName->equal(new LiveName('test')));
    }
}
