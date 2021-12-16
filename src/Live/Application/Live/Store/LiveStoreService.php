<?php

declare(strict_types=1);

namespace Lee\Live\Application\Live\Store;

use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Artist\ArtistRepository;
use Lee\Live\Domain\Model\Live\LiveFactory;
use Lee\Live\Domain\Model\Live\LiveRepository;
use Lee\Live\Domain\Model\Live\RegisteredLiveEvent;

final class LiveStoreService
{
    public function __construct(
        private LiveRepository $liveRepository,
        private ArtistRepository $artistRepository,
    ) {
    }

    public function execute(LiveStoreRequest $request): LiveStoreResponse
    {
        $live = (new LiveFactory($this->artistRepository))->factoryFromPrimitive(
            $request->getLiveName(),
            $request->getLiveDate(),
            $request->getLiveHouseName(),
            $request->getPrefecture(),
            $request->getAddress(),
            $request->getActorIds(),
        );

        $this->liveRepository->store($live->toDto());

        $live->issueRegisteredLiveEvent();

        return new LiveStoreResponse(true);
    }
}
