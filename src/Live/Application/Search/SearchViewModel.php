<?php

declare(strict_types=1);

namespace Lee\Live\Application\Search;

use Lee\Live\Shared\Date;
use Lee\Live\Domain\Model\Live\Id;
use Lee\Live\Domain\Model\Live\LiveHouse\Prefecture;
use Lee\Live\Domain\Model\Live\LiveId;
use Lee\Live\Domain\Model\Live\Name;
use Lee\Live\Shared\ViewModel;

class SearchViewModel implements ViewModel
{

    /**
     * @param LiveId $id
     * @param Name|null $liveHouseName
     * @param Date|null $ticketSaleStartDate
     * @param Date|null $liveStartDate
     * @param array|null $actors
     * @param Prefecture|null $prefecture
     */
    public function __construct(
        private LiveId $id,
        private ?Name $liveHouseName,
        private ?Date $ticketSaleStartDate,
        private ?Date $liveStartDate,
        private ?array $actors,
        private ?Prefecture $prefecture,
    ) {
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id'                  => $this->id(),
            'liveHouseName'       => $this->liveHouseName(),
            'ticketSaleStartDate' => $this->ticketSaleStartDate(),
            'liveStartDate'       => $this->liveStartDate(),
            'actors'              => array_map(function (Name $aActor) {
                return (string)$aActor;
            }, $this->actors()),
            'prefecture' => $this->prefecture(),
        ];
    }

    private function id(): string
    {
        return (string)$this->id;
    }

    private function liveHouseName(): string
    {
        return (string)$this->liveHouseName;
    }

    private function ticketSaleStartDate(): string
    {
        return (string)$this->ticketSaleStartDate?->format('Y年n月j日 H時i分');
    }

    private function liveStartDate(): string
    {
        return (string)$this->liveStartDate?->format('Y年n月j日 H時i分');
    }

    /**
     * @return Name[]
     */
    private function actors(): array
    {
        return $this->actors ?? [];
    }

    private function prefecture(): string
    {
        return (string)$this->prefecture;
    }
}
