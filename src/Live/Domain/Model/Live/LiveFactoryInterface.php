<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Live;

interface LiveFactoryInterface
{
    public function factoryFromPrimitive(string $liveName, string $liveDate, string $liveHouseName, string $prefecture, string $address, array $actorIds): Live;
}
