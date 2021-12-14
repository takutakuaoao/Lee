<?php

declare(strict_types=1);

namespace Tests\Unit\Live\Infrastructure\External\Notification\LiveReportSender;

use App\Mail\LiveReportMailable;
use Illuminate\Support\Facades\Mail;
use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Live\RegisteredLiveEvent;
use Lee\Live\Domain\Model\LiveReport\LiveReportNotifier;
use Lee\Live\Domain\Model\User\Email;
use Lee\Live\Domain\Model\User\UserFactory;
use Lee\Live\Infrastructure\DataResource\ArtistRepository\NonConnectionDataResourceArtistRepository;
use Lee\Live\Infrastructure\External\Notification\LiveReportSenderService\LiveReportMailerService;
use Tests\TestCase;

class LiveReportMailerServiceTest extends TestCase
{
    public function test_send_mail(): void
    {
        $registeredLiveEvent = new RegisteredLiveEvent(
            [new ArtistId('artist-1'), new ArtistId('artist-2')],
            'ライブ名',
            '2021-01-01 00:00:00',
            'ライブハウス名',
            '住所',
        );
        $users = [
            (new UserFactory)->createGeneralUser(new Email('test@test.com'))->registerArtist(new ArtistId('artist-1')),
        ];
        $liveReportNotifier = new LiveReportNotifier(
            $registeredLiveEvent,
            $users,
        );

        $mailer = new LiveReportMailerService(new NonConnectionDataResourceArtistRepository);
        $mailer->send($liveReportNotifier);

        Mail::assertSent(LiveReportMailable::class, 1);
        Mail::assertSent(LiveReportMailable::class, function ($mail) {
            return $mail->hasTo('test@test.com');
        });
    }
}
