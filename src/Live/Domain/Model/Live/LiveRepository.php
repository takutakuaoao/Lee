<?php

namespace Lee\Live\Domain\Model\Live;

interface LiveRepository
{
    public function store(LiveDto $liveDto): void;
    public function existsById(LiveId $liveId): bool;
}
