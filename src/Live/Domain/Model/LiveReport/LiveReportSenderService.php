<?php

declare(strict_types=1);

namespace Lee\Live\Domain\Model\LiveReport;

interface LiveReportSenderService
{
    public function send(LiveReportNotifier $liveReportNotifier): void;
}
