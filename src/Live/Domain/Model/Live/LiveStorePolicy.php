<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\Live;

use Lee\Live\Shared\Date;
use Lee\Live\Shared\Exception\PolicyException;

final class LiveStorePolicy
{
    public function __construct(private Date $storeDate, private LiveRepository $liveRepository)
    {
    }

    public function isSatisfied(Live $live): bool
    {
        if (!$live->getLiveDate()->isAfter($this->storeDate)) {
            throw new PolicyException('ライブの新規登録時は、登録日以降のライブ日程を設定してください。');
        }

        if ($this->liveRepository->existsById($live->getLiveId())) {
            throw new PolicyException('ライブの新規登録時は、重複したIDのライブ情報は入力できません。');
        }

        return true;
    }
}
