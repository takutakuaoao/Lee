<?php

declare(strict_types=1);

namespace Lee\Live\Infrastructure\External\Notification\LiveReportSenderService;

use App\Mail\LiveReportMailable;
use Illuminate\Support\Facades\Mail;
use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Artist\ArtistRepository;
use Lee\Live\Domain\Model\LiveReport\LiveReportNotifier;
use Lee\Live\Domain\Model\LiveReport\LiveReportSenderService;

final class LiveReportMailerService implements LiveReportSenderService
{
    private const SUBJECT       = '【Lee】ライブ情報更新通知';
    private const MAIL_TEMPLATE = 'notification.mail.live_report';

    public function __construct(
        private ArtistRepository $artistRepository,
    ) {
    }

    public function send(LiveReportNotifier $liveReportNotifier): void
    {
        foreach ($liveReportNotifier->getUsers() as $user) {
            $artists = array_map(function (ArtistId $artistId) {
                $artist = $this->artistRepository->findById($artistId);

                return $artist->getName();
            }, $user->selectFavoriteArtist($liveReportNotifier->getActorIds()));

            Mail::to((string)$user->getEmail())->send(new LiveReportMailable(
                self::MAIL_TEMPLATE,
                self::SUBJECT,
                $liveReportNotifier->getLiveName(),
                $liveReportNotifier->getLiveDate(),
                $liveReportNotifier->getLiveHouseName(),
                $liveReportNotifier->getLiveHouseLocation(),
                implode('、', $artists),
            ));
        }
    }
}
