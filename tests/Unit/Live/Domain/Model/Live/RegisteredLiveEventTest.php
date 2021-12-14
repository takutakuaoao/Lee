<?php

namespace Tests\Unit\Live\Domain\Model\Live;

use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Live\RegisteredLiveEvent;
use Lee\Live\Shared\Exception\EventException;
use Tests\TestCase;

class RegisteredLiveEventTest extends TestCase
{
    public function test_create(): void
    {
        $event = new RegisteredLiveEvent(
            [new ArtistId('1')],
            'ライブ名',
            '2021-01-01 00:00:00',
            'ライブハウス名',
            '東京都 住所',
        );

        $this->assertEquals('ライブ名', $event->getLiveName());
        $this->assertEquals('2021-01-01 00:00:00', $event->getLiveDate());
        $this->assertEquals('ライブハウス名', $event->getLiveHouseName());
        $this->assertEquals('東京都 住所', $event->getLiveHouseLocation());
        $this->assertTrue($event->getArtistIds()[0]->equal(new ArtistId('1')));
    }

    public function test_construct_error(): void
    {
        $this->expectException(EventException::class);

        new RegisteredLiveEvent(
            ['1'],
            'ライブ名',
            '2021-01-01 00:00:00',
            'ライブハウス名',
            '東京都 住所',
        );
    }

    public function test_throw_exception_dispatch_event(): void
    {
        $this->expectException(EventException::class);

        RegisteredLiveEvent::dispatch(
            ['1'],
            'ライブ名',
            '2021-01-01 00:00:00',
            'ライブハウス名',
            '東京都 住所',
        );
    }
}
