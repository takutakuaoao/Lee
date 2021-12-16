<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Domain\Model\Live;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Lee\Live\Domain\Model\Live\LiveFactory;
use Lee\Live\Domain\Model\Live\LiveName;
use Lee\Live\Infrastructure\DataResource\ArtistRepository\InMemoryArtistRepository;
use Lee\Live\Infrastructure\DataResource\ArtistRepository\NonConnectionDataResourceArtistRepository;
use Lee\Live\Infrastructure\DataResource\ArtistRepository\QueryBuilderArtistRepository;
use Tests\TestCase;

class LiveFactoryTest extends TestCase
{
    public function test_from_primitive(): void
    {
        $factory = new LiveFactory(new NonConnectionDataResourceArtistRepository);

        $live       = $factory->factoryFromPrimitive('live名', '2021/01/01 00:00', 'ライブハウス名', '東京', '住所', ['test1', 'test2']);
        $primitives = $live->toPrimitives();

        $this->assertEquals('live名', $primitives['liveName']);
        $this->assertEquals('2021/01/01 00:00:00', $primitives['liveDate']);
        $this->assertEquals('ライブハウス名: ライブハウス名, 所在地: 東京 住所', $primitives['liveHouse']);
        $this->assertEquals('test1', $primitives['actors'][0]);
        $this->assertEquals('test2', $primitives['actors'][1]);
    }
}
