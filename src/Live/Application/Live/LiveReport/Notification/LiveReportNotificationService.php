<?php

declare(strict_types=1);

namespace Lee\Live\Application\Live\LiveReport\Notification;

use Lee\Live\Domain\Model\Artist\ArtistRepository;
use Lee\Live\Domain\Model\Live\RegisteredLiveEvent;
use Lee\Live\Domain\Model\LiveReport\LiveReportNotifier;
use Lee\Live\Domain\Model\LiveReport\LiveReportSenderService;
use Lee\Live\Domain\Model\User\UserRepository;

final class LiveReportNotificationService
{
    public function __construct(
        private UserRepository $userRepository,
        private LiveReportSenderService $liveReportSenderService,
    ) {
    }

    public function handle(RegisteredLiveEvent $event)
    {
        $liveReportNotifier = new LiveReportNotifier($event, $this->userRepository->findByMultipleArtistId($event->getArtistIds()));

        $this->liveReportSenderService->send($liveReportNotifier);
    }
}
