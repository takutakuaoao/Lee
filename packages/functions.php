<?php

namespace Lee;

if (!\function_exists('Lee\\makeString')) {
    function makeString(int $count, string $character = 'a')
    {
        $string = '';

        for($i = 0; $i < $count; $i++) {
            $string .= $character;
        }

        return $string;
    }
}
