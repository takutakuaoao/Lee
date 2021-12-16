<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Domain\Model\Live;

use Lee\Live\Domain\Model\Live\LiveFactory;
use Lee\Live\Domain\Model\Live\LiveStorePolicy;
use Lee\Live\Infrastructure\DataResource\ArtistRepository\NonConnectionDataResourceArtistRepository;
use Lee\Live\Infrastructure\DataResource\LiveRepository\NonConnectionDataResourceLiveRepository;
use Lee\Live\Shared\Date;
use Lee\Live\Shared\Exception\PolicyException;
use PHPUnit\Framework\TestCase;

class LiveStorePolicyTest extends TestCase
{
    public function test_is_satisfied_by_store_date_before_live_date(): void
    {
        $policy = new LiveStorePolicy(Date::factoryFromString('2021-01-02 00:00:00'), new NonConnectionDataResourceLiveRepository);

        $liveDate = '2021-01-02 00:01:00';
        $live     = (new LiveFactory(new NonConnectionDataResourceArtistRepository))->factoryFromPrimitive(
            'ライブ名',
            $liveDate,
            'テスト',
            '東京',
            '住所',
            ['1'],
        );

        $this->assertTrue($policy->isSatisfied($live));
    }

    public function test_throw_exception_satisfied_by_not_unique_live_id(): void
    {
        $this->expectException(PolicyException::class);

        $liveDate = '2021-01-02 00:01:00';
        $live     = (new LiveFactory(new NonConnectionDataResourceArtistRepository))->factoryFromPrimitive(
            'ライブ名',
            $liveDate,
            'テスト',
            '東京',
            '住所',
            ['1'],
        );
        $mockRepository             = new NonConnectionDataResourceLiveRepository;
        $mockRepository->returnBool = true;

        $policy = new LiveStorePolicy(Date::factoryFromString('2021-01-02 00:00:00'), $mockRepository);

        $policy->isSatisfied($live);
    }
}
