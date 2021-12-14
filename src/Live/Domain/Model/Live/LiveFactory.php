<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Live;

use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Artist\ArtistRepository;
use Lee\Live\Domain\Model\Live\LiveHouse\Address;
use Lee\Live\Domain\Model\Live\LiveHouse\LiveHouse;
use Lee\Live\Domain\Model\Live\LiveHouse\Location;
use Lee\Live\Domain\Model\Live\LiveHouse\Prefecture;
use Lee\Live\Shared\Date;
use Lee\Live\Shared\Name;

final class LiveFactory implements LiveFactoryInterface
{
    public function __construct(private ArtistRepository $artistRepository)
    {
    }

    public function factoryFromPrimitive(string $liveName, string $liveDate, string $liveHouseName, string $prefecture, string $address, array $actorIds): Live
    {
        $actors = array_map(function ($actorId) {
            return new ArtistId($actorId);
        }, $actorIds);

        return new Live(
            new LiveId(),
            new LiveName($liveName),
            new LiveHouse(new Name($liveHouseName), new Location(new Prefecture($prefecture), new Address($address))),
            Date::factoryFromString($liveDate),
            $actors,
            $this->artistRepository,
        );
    }
}
