<?php

declare(strict_types=1);

namespace Lee\Live\Infrastructure\DataResource\LiveRepository;

use Lee\Live\Domain\Model\Live\LiveDto;
use Lee\Live\Domain\Model\Live\LiveId;
use Lee\Live\Domain\Model\Live\LiveRepository;

final class NonConnectionDataResourceLiveRepository implements LiveRepository
{
    public int $countUsedStoreMethod = 0;
    public bool $returnBool          = false;

    public function store(LiveDto $liveDto): void
    {
        $this->countUsedStoreMethod++;
    }

    public function existsById(LiveId $liveId): bool
    {
        return $this->returnBool;
    }
}
