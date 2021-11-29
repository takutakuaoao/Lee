<?php

namespace Lee\LiveSearch\Domain\Value;

use InvalidArgumentException;

class TimeSchedule
{
    private Date $open;
    private ?Date $start;
    private Date $end;

    public function __construct(Date $open, ?Date $start, Date $end)
    {
        if (is_null($start)) {
            $start = $open;
        }

        if (!$open->isUntil($start) || !$start->isBefore($end)) {
            throw new InvalidArgumentException("Invalid error [open]{$open} [start]{$start} [end]{$end}");
        }

        $this->open = $open;
        $this->start = $start;
        $this->end = $end;
    }

    public function __toString()
    {
        return '[open] ' . $this->open . ' [start] ' . $this->start . ' [end] ' . $this->end;
    }
}
