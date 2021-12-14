<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\LiveReport;

use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Live\RegisteredLiveEvent;
use Lee\Live\Domain\Model\User\User;

final class LiveReportNotifier
{
    /**
     * @param RegisteredLiveEvent $registeredLiveEvent
     * @param User[]              $users
     */
    public function __construct(
        private RegisteredLiveEvent $registeredLiveEvent,
        private array $users,
    ) {
    }

    public function notifier(LiveReportSenderService $service): void
    {
        $service->send($this);
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @return ArtistId[]
     */
    public function getActorIds(): array
    {
        return $this->registeredLiveEvent->getArtistIds();
    }

    public function getEmails(): array
    {
        return array_map(fn (User $user) => $user->getEmail(), $this->users);
    }

    public function getLiveName(): string
    {
        return $this->registeredLiveEvent->getLiveName();
    }

    public function getLiveDate(): string
    {
        return $this->registeredLiveEvent->getLiveDate();
    }

    public function getLiveHouseName(): string
    {
        return $this->registeredLiveEvent->getLiveHouseName();
    }

    public function getLiveHouseLocation(): string
    {
        return $this->registeredLiveEvent->getLiveHouseLocation();
    }
}
