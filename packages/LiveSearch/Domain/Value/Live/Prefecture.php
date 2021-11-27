<?php

namespace Lee\LiveSearch\Domain\Value\Live;

class Prefecture
{
    /** @var string */
    private $value;

    public function __construct(string $prefecture)
    {
        $this->value = $prefecture;
    }

    public function __toString()
    {
        return $this->value;
    }
}
