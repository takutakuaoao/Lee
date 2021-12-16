<?php

declare(strict_types=1);

namespace Lee\Live\Application\Artist\Store;

use Lee\Live\Domain\Model\Artist\ArtistFactory;
use Lee\Live\Domain\Model\Artist\ArtistRepository;
use Lee\Live\Domain\Model\Live\Name;

final class ArtistStoreService
{
    public function __construct(
        private ArtistRepository $artistRepository,
    ) {
    }

    public function execute(ArtistStoreRequest $request): ArtistStoreResponse
    {
        $artist = (new ArtistFactory)->createNewArtist(new Name($request->getArtistName()));

        $this->artistRepository->store($artist->toDto());

        return new ArtistStoreResponse(true);
    }
}
