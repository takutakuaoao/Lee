<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Live;

use Illuminate\Auth\Events\Registered;
use Lee\Live\Domain\Model\Artist\ArtistId;
use Lee\Live\Domain\Model\Artist\ArtistRepository;
use Lee\Live\Domain\Model\Live\LiveHouse\LiveHouse;
use Lee\Live\Shared\Date;
use Lee\Live\Shared\Exception\NotFoundException;

final class Live
{
    private array $events = [];

    /**
     * @param LiveId           $id
     * @param LiveName         $liveName
     * @param LiveHouse        $liveHouse
     * @param Date             $liveDate
     * @param ArtistId[]       $actors
     * @param ArtistRepository $artistRepository
     */
    public function __construct(
        private LiveId $id,
        private LiveName $liveName,
        private LiveHouse $liveHouse,
        private Date $liveDate,
        private array $actors,
        ArtistRepository $artistRepository,
    ) {
        $notFoundArtists = array_filter($actors, function ($artistId) use ($artistRepository) {
            return !$artistRepository->exists($artistId);
        });

        if (count($notFoundArtists) > 0) {
            throw new NotFoundException();
        }

        $this->actors = $actors;
    }

    public function issueRegisteredLiveEvent(): void
    {
        RegisteredLiveEvent::dispatch(
            $this->actors,
            (string)$this->liveName,
            (string)$this->liveDate,
            (string)$this->liveHouse->getLiveHouseName(),
            (string)$this->liveHouse->getLocation(),
        );
    }

    public function toDto(): LiveDto
    {
        $liveHousePrimitives = $this->liveHouse->toPrimitives();
        $actorIds            = array_map(fn (ArtistId $id) => (string)$id, $this->actors);

        return new LiveDto(
            (string)$this->id,
            (string)$this->liveName,
            (string)$this->liveDate,
            $liveHousePrimitives['name'],
            $liveHousePrimitives['prefecture'],
            $liveHousePrimitives['address'],
            $actorIds,
        );
    }

    public function toPrimitives(): array
    {
        return [
            'id'        => (string)$this->id,
            'liveName'  => (string)$this->liveName,
            'liveHouse' => (string)$this->liveHouse,
            'liveDate'  => (string)$this->liveDate,
            'actors'    => array_map(fn (ArtistId $actor)    => (string)$actor, $this->actors),
        ];
    }

    public function getLiveId(): LiveId
    {
        return $this->id;
    }

    public function getLiveDate(): Date
    {
        return $this->liveDate;
    }

    public function equal(Live $live): bool
    {
        return $this->id->equal($live->id);
    }

    public function __toString()
    {
        return "[Live Instance Id] {$this->id}";
    }
}
