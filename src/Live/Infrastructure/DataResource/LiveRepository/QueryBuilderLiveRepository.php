<?php

declare(strict_types=1);

namespace Lee\Live\Infrastructure\DataResource\LiveRepository;

use Illuminate\Support\Facades\DB;
use Lee\Live\Domain\Model\Live\LiveDto;
use Lee\Live\Domain\Model\Live\LiveId;
use Lee\Live\Domain\Model\Live\LiveRepository;

final class QueryBuilderLiveRepository implements LiveRepository
{
    public function store(LiveDto $live): void
    {
        $liveHouseId = uniqid('', true);

        DB::transaction(function () use ($live, $liveHouseId) {
            DB::table('live_houses')->insert([
                'id'         => $liveHouseId,
                'name'       => $live->getLiveHouseName(),
                'prefecture' => $live->getPrefecture(),
                'address'    => $live->getAddress(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('lives')->insert([
                'id'            => $live->getLiveId(),
                'name'          => $live->getLiveName(),
                'start_date'    => $live->getStartDate(),
                'live_house_id' => $liveHouseId,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            foreach ($live->getActorIds() as $actorId) {
                DB::table('live_actors')->insert([
                    'live_id'   => $live->getLiveId(),
                    'artist_id' => $actorId,
                ]);
            }
        });
    }

    public function existsById(LiveId $liveId): bool
    {
        $query = DB::table('lives')->where('id', (string)$liveId);

        return $query->exists();
    }
}
