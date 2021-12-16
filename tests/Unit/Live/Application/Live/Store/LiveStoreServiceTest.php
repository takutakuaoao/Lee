<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Application\Live\Store;

use Illuminate\Support\Facades\Event;
use Lee\Live\Application\Live\Store\LiveStoreRequest;
use Lee\Live\Application\Live\Store\LiveStoreService;
use Lee\Live\Domain\Model\Live\RegisteredLiveEvent;
use Lee\Live\Infrastructure\DataResource\ArtistRepository\NonConnectionDataResourceArtistRepository;
use Lee\Live\Infrastructure\DataResource\LiveRepository\NonConnectionDataResourceLiveRepository;
use Tests\TestCase;

class LiveStoreServiceTest extends TestCase
{
    public function test_execute_success(): void
    {
        $request = new LiveStoreRequest(
            'ライブ名',
            '2021-01-01 00:00:00',
            'Zepp Tokyo',
            '東京都',
            '住所',
            ['artist1', 'artist2'],
        );
        $service = new LiveStoreService(
            $repository = new NonConnectionDataResourceLiveRepository,
            new NonConnectionDataResourceArtistRepository,
        );

        $response = $service->execute($request);

        $this->assertTrue($response->getResult());
        $this->assertEquals(1, $repository->countUsedStoreMethod);

        Event::assertDispatched(RegisteredLiveEvent::class);
    }


}
