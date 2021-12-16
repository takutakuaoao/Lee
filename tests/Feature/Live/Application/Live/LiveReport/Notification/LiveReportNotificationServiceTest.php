<?php

declare(strict_types=1);

namespace Tests\Feature\Live\Application\Live\LiveReport\Notification;

use App\Mail\LiveReportMailable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Lee\Live\Application\Live\LiveReport\Notification\LiveReportNotificationService;
use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Live\RegisteredLiveEvent;
use Lee\Live\Infrastructure\DataResource\ArtistRepository\QueryBuilderArtistRepository;
use Lee\Live\Infrastructure\DataResource\UserRepository\QueryBuilderUserRepository;
use Lee\Live\Infrastructure\External\Notification\LiveReportSenderService\LiveReportMailerService;
use Tests\TestCase;

class LiveReportNotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        DB::table('users')->insert([
            'id'       => 'user-id-1',
            'email'    => 'test1@test.com',
            'password' => 'test',
            'type'     => 1,
        ]);
        DB::table('artists')->insert([
            'id'   => 'artist-id-1',
            'name' => 'artist-name',
        ]);
        DB::table('favorite_artists')->insert([
            'user_id'   => 'user-id-1',
            'artist_id' => 'artist-id-1',
        ]);
    }

    public function test_execute(): void
    {
        $event = new RegisteredLiveEvent(
            [new ArtistId('artist-id-1')],
            'ライブ名',
            '2021-01-01 00:00:00',
            'ライブハウス名',
            '住所',
        );

        $service = new LiveReportNotificationService(
            new QueryBuilderUserRepository,
            new LiveReportMailerService(new QueryBuilderArtistRepository),
        );

        $service->handle($event);

        Mail::assertSent(LiveReportMailable::class, function ($mail) {
            return $mail->hasTo('test1@test.com');
        });
    }
}
