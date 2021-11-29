<?php

namespace Lee\LiveSearch\Domain\Value\Location;

class Location
{
    /** @var Prefecture */
    private $prefecture;

    /** @var Address */
    private $address;

    public function __construct(Prefecture $prefecture, Address $address)
    {
        $this->prefecture = $prefecture;
        $this->address    = $address;
    }

    public function __toString()
    {
        return $this->prefecture . ' ' . $this->address;
    }
}
