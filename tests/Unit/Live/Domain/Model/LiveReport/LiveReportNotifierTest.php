<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Domain\Model\LiveReport;

use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Live\RegisteredLiveEvent;
use Lee\Live\Domain\Model\LiveReport\LiveReportNotifier;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\User;
use Lee\Live\Domain\Model\User\UserFactory;
use Lee\Live\Domain\Model\User\UserId;
use Lee\Live\Domain\Model\User\UserType;
use PHPUnit\Framework\TestCase;

class LiveReportNotifierTest extends TestCase
{
    /** @var User[] */
    private array $users;

    private RegisteredLiveEvent $registeredLiveEvent;

    private LiveReportNotifier $liveReportNotifier;

    public function setUp(): void
    {
        parent::setUp();

        $this->users = [
            (new UserFactory)->createUser(
                new UserId('test-user'),
                new Email('test@test.com'),
                UserType::general(),
                [new ArtistId('test-artist')]
            ),
        ];

        $this->registeredLiveEvent = new RegisteredLiveEvent(
            [new ArtistId('test-artist')],
            'ライブ名',
            '2021-01-01 00:00:00',
            'サウンドクルー',
            '北海道 札幌市 xxx',
        );

        $this->liveReportNotifier = new LiveReportNotifier($this->registeredLiveEvent, $this->users);
    }

    public function test_get_live_name(): void
    {
        $this->assertEquals('ライブ名', $this->liveReportNotifier->getLiveName());
    }

    public function test_get_live_date(): void
    {
        $this->assertEquals('2021-01-01 00:00:00', $this->liveReportNotifier->getLiveDate());
    }

    public function test_get_live_house_name(): void
    {
        $this->assertEquals('サウンドクルー', $this->liveReportNotifier->getLiveHouseName());
    }

    public function test_get_live_house_location(): void
    {
        $this->assertEquals('北海道 札幌市 xxx', $this->liveReportNotifier->getLiveHouseLocation());
    }
}
