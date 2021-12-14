<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LiveReportMailable extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private string $mailTemplate,
        private string $mailSubject,
        private string $liveName,
        private string $liveDate,
        private string $liveHouseName,
        private string $liveHouseLocation,
        private string $artistName,
    ) {
    }

    public function build(): self
    {
        return $this->subject($this->mailSubject)->text($this->mailTemplate);
    }
}
